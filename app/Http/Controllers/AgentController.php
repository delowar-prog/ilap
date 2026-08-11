<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Campus;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $query = Agent::with(['campus', 'parentAgent'])
            // 1. Branch isolation: filter by campus if not super admin
            ->when(! $isSuperAdmin, fn ($q) => $q->where('campus_id', $user->campus_id))

            // 2. Search filter
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('agent_code', 'like', "%{$search}%");
                });
            })

            // 3. Campus filter for super admin
            ->when($isSuperAdmin && request('campus_id'), fn ($q) => $q->where('campus_id', request('campus_id')))

            // 4. Agent type filter
            ->when(request('agent_type'), fn ($q) => $q->where('agent_type', request('agent_type')))

            // 5. Status filter
            ->when(request('status'), fn ($q) => $q->where('status', request('status')));

        $sortDir = request('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $agents = $query->orderBy('id', $sortDir)->paginate(request('per_page', 10))->withQueryString();

        $campuses = Campus::where('status', 'active')->select('id', 'name')->get();

        // Fetch Master Agents for Sub-Agent dropdown selection
        $masterAgents = Agent::where('agent_type', 'master')
            ->when(! $isSuperAdmin, fn ($q) => $q->where('campus_id', $user->campus_id))
            ->select('id', 'name', 'agent_code')
            ->get();

        return view('backend.agents.index', compact('agents', 'campuses', 'masterAgents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campuses = Campus::where('status', 'active')
            ->select('id', 'name', 'campus_code')
            ->get();

        $masterAgents = Agent::where('agent_type', 'master')
            ->when(! auth()->user()->hasRole('Super Admin'), fn ($q) => $q->where('campus_id', auth()->user()->campus_id))
            ->where('status', 'active')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'name', 'agent_code')
            ->get();

        // Countries with phone codes for the phone number selector
        $countries = Country::where('status', 'active')
            ->orderBy('name')
            ->select('id', 'name', 'iso2', 'phone_code')
            ->get();

        return view('backend.agents.create', compact('campuses', 'masterAgents', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'campus_id' => 'nullable|exists:campuses,id',
            'agent_type' => 'required|in:master,sub_agent',
            'parent_agent_id' => 'required_if:agent_type,sub_agent|nullable|exists:agents,id',
            'agent_code' => 'nullable|string|max:50|unique:agents,agent_code',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:agents,email',
            'phone_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:active,inactive',
        ]);
        // Generate Agent Code (Promo Code)
        $agentCode = $validated['agent_code'] ?? $this->generateAgentCode(
            $validated['campus_id'] ?? auth()->user()->campus_id,
            $validated['first_name'],
            $validated['last_name']
        );

        DB::transaction(function () use ($request, $validated, $agentCode) {
            // 1. Upload photo and logo
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('agents/photos', 'public');
            }

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('agents/logos', 'public');
            }

            // 2. Generate full name
            $fullName = trim("{$validated['first_name']} ".($validated['middle_name'] ?? '')." {$validated['last_name']}");

            // Create user account
            $user = User::create([
                'user_first_name' => $validated['first_name'],
                'user_middle_name' => $validated['middle_name'] ?? null,
                'user_last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'photo' => $photoPath,
                'campus_id' => $validated['campus_id'] ?? auth()->user()->campus_id,
                'password' => Hash::make($request->password),
                'status' => $validated['status'] ?? 'active',
            ]);

            // 3. Create Agent record
            Agent::create([
                'campus_id' => $validated['campus_id'] ?? auth()->user()->campus_id,
                'parent_agent_id' => $validated['agent_type'] === 'sub_agent' ? $validated['parent_agent_id'] : null,
                'agent_code' => $agentCode,
                'agent_type' => $validated['agent_type'],
                'name' => $fullName,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone_code' => $validated['phone_code'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'photo' => $photoPath,
                'logo' => $logoPath,
                'status' => $validated['status'] ?? 'active',
            ]);
        });

        return redirect()
            ->route('agents.index')
            ->with('success', 'Agent created successfully with Promo Code: '.$agentCode);
    }

    /**
     * Generate unique Agent Code (Promo Code)
     * Format: [CampusCode] + AGT + [5 digit random] + [FirstCharOfFirstName] + [FirstCharOfLastName]
     * Example: DHKAGT12345RU
     */
    private function generateAgentCode($campusId, $firstName, $lastName): string
    {
        // 1. Resolve Campus Code
        $campusCode = 'HQ'; // Default fallback
        if ($campusId) {
            $campus = Campus::find($campusId);
            if ($campus && ! empty($campus->campus_code)) {
                $campusCode = strtoupper($campus->campus_code);
            }
        }

        // 2. Extract uppercase initials
        $firstChar = strtoupper(substr(trim($firstName), 0, 1));
        $lastChar = strtoupper(substr(trim($lastName), 0, 1));

        // 3. Fallback character if empty
        $firstChar = $firstChar ?: 'X';
        $lastChar = $lastChar ?: 'X';

        // 4. Generate unique code
        $maxAttempts = 10;
        $attempts = 0;

        do {
            $random5Digit = rand(10000, 99999);
            $generatedCode = $campusCode.'AGT'.$random5Digit.$firstChar.$lastChar;
            $attempts++;
        } while (Agent::where('agent_code', $generatedCode)->exists() && $attempts < $maxAttempts);

        return $generatedCode;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agent = Agent::findOrFail($id);

        // Branch Isolation Check
        $user = auth()->user();
        if (! $user->hasRole('Super Admin') && $agent->campus_id != $user->campus_id) {
            abort(403, 'Unauthorized action. You cannot edit agents from other campuses.');
        }

        // Fetch campuses (All for Super Admin, own campus for others)
        $campuses = Campus::when(! $user->hasRole('Super Admin'), fn ($q) => $q->where('id', $user->campus_id))
            ->where('status', 'active')
            ->select('id', 'name', 'campus_code')
            ->get();

        // Fetch Master Agents excluding self
        $masterAgents = Agent::where('agent_type', 'master')
            ->when(! $user->hasRole('Super Admin'), fn ($q) => $q->where('campus_id', $user->campus_id))
            ->where('status', 'active')
            ->where('id', '!=', $agent->id)
            ->select('id', 'name', 'agent_code', 'first_name', 'last_name')
            ->get();

        return view('backend.agents.edit', compact('agent', 'campuses', 'masterAgents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $validated = $request->validate([
            'campus_id' => 'nullable|exists:campuses,id',
            'agent_type' => 'required|in:master,sub_agent',
            'parent_agent_id' => 'required_if:agent_type,sub_agent|nullable|exists:agents,id',
            'agent_code' => 'nullable|string|max:50|unique:agents,agent_code,'.$agent->id,
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:agents,email,'.$agent->id,
            'phone_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|in:active,inactive',
        ]);

        DB::transaction(function () use ($request, $validated, $agent) {
            // Photo/Logo update logic...
            if ($request->hasFile('photo')) {
                if ($agent->photo && \Storage::disk('public')->exists($agent->photo)) {
                    \Storage::disk('public')->delete($agent->photo);
                }
                $agent->photo = $request->file('photo')->store('agents/photos', 'public');
            }

            if ($request->hasFile('logo')) {
                if ($agent->logo && \Storage::disk('public')->exists($agent->logo)) {
                    \Storage::disk('public')->delete($agent->logo);
                }
                $agent->logo = $request->file('logo')->store('agents/logos', 'public');
            }

            $fullName = trim("{$validated['first_name']} ".($validated['middle_name'] ?? '')." {$validated['last_name']}");

            // Agent Code - keep existing code if not manually specified
            $agentCode = $validated['agent_code'] ?? $agent->agent_code;

            $agent->update([
                'campus_id' => $validated['campus_id'] ?? $agent->campus_id,
                'parent_agent_id' => $validated['agent_type'] === 'sub_agent' ? $validated['parent_agent_id'] : null,
                'agent_code' => $agentCode,
                'agent_type' => $validated['agent_type'],
                'name' => $fullName,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone_code' => $validated['phone_code'] ?? $agent->phone_code,
                'phone' => $validated['phone'] ?? $agent->phone,
                'status' => $validated['status'] ?? $agent->status,
            ]);
        });

        return redirect()
            ->route('agents.index')
            ->with('success', 'Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);

        // Branch Isolation Check
        $user = auth()->user();
        if (! $user->hasRole('Super Admin') && $agent->campus_id != $user->campus_id) {
            abort(403, 'Unauthorized action.');
        }

        // Safe Delete Checks
        $subAgentsCount = $agent->subAgents()->count();
        if ($subAgentsCount > 0) {
            return back()->with('error', "Cannot delete! This agent has {$subAgentsCount} sub-agent(s) under it. Please reassign them first.");
        }

        $studentsCount = $agent->students()->count();
        if ($studentsCount > 0) {
            return back()->with('error', "Cannot delete! This agent has {$studentsCount} student(s) assigned. Please reassign them first.");
        }

        $commissionsCount = $agent->commissions()->count();
        if ($commissionsCount > 0) {
            return back()->with('error', "Cannot delete! This agent has {$commissionsCount} commission setup(s). Please remove commissions first.");
        }

        // Delete Files from Storage
        if ($agent->photo && Storage::disk('public')->exists($agent->photo)) {
            Storage::disk('public')->delete($agent->photo);
        }
        if ($agent->logo && Storage::disk('public')->exists($agent->logo)) {
            Storage::disk('public')->delete($agent->logo);
        }

        $agentName = $agent->name;
        $agent->delete();

        return back()->with('success', "Agent '{$agentName}' deleted successfully.");
    }
}
