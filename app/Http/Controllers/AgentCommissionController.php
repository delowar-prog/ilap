<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentCommission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentCommissionController extends Controller
{
    /**
     * Display a listing of commissions.
     */
    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');
        $isMasterAgent = $user->hasRole('Master Agent');

        // HQ sees all, Master Agent sees own and sub-agent commissions
        $query = AgentCommission::with(['agent', 'course', 'agent.campus'])
            ->when(!$isSuperAdmin, function ($q) use ($user) {
                if ($user->hasRole('Master Agent')) {
                    // Master Agent own and sub-agent commissions
                    $subAgentIds = Agent::where('parent_agent_id', $user->agent->id ?? 0)->pluck('id');
                    $q->whereIn('agent_id', $subAgentIds->push($user->agent->id ?? 0));
                } else {
                    $q->where('agent_id', $user->agent->id ?? 0);
                }
            })
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->whereHas('agent', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('agent_code', 'like', "%{$search}%");
                });
            })
            ->when(request('agent_id'), fn($q) => $q->where('agent_id', request('agent_id')))
            ->when(request('commission_type'), fn($q) => $q->where('commission_type', request('commission_type')))
            ->when(request('course_id'), fn($q) => $q->where('course_id', request('course_id')));

        $sortDir = request('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $commissions = $query->orderBy('id', $sortDir)->paginate(15)->withQueryString();

        // Fetch agents data for dropdown
        $agents = Agent::when(!$isSuperAdmin, function ($q) use ($user) {
                if ($user->hasRole('Master Agent')) {
                    $subAgentIds = Agent::where('parent_agent_id', $user->agent->id ?? 0)->pluck('id');
                    $q->whereIn('id', $subAgentIds->push($user->agent->id ?? 0));
                } else {
                    $q->where('id', $user->agent->id ?? 0);
                }
            })
            ->where('status', 'active')
            ->select('id', 'name', 'agent_code', 'agent_type')
            ->get();

        $courses = Course::where('status', 'active')
            ->select('id', 'name', 'fee', 'currency')
            ->get();

        return view('backend.commissions.index', compact('commissions', 'agents', 'courses'));
    }

    /**
     * Show the form for creating a new commission.
     */
    public function create()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');
        $isMasterAgent = $user->hasRole('Master Agent');

        // HQ sees all agents, Master Agent sees own sub-agents
        $agents = Agent::when(!$isSuperAdmin, function ($q) use ($user) {
                if ($user->hasRole('Master Agent')) {
                    $q->where('parent_agent_id', $user->agent->id ?? 0)
                      ->orWhere('id', $user->agent->id);
                } else {
                    $q->where('id', $user->agent->id ?? 0);
                }
            })
            ->where('status', 'active')
            ->select('id', 'name', 'agent_code', 'agent_type')
            ->orderBy('name')
            ->get();

        $courses = Course::where('status', 'active')
            ->select('id', 'name', 'fee', 'currency')
            ->orderBy('name')
            ->get();

        $currencies = config('currencies', ['GBP', 'USD', 'BDT', 'SHS', 'AED', 'INR', 'EUR']);

        return view('backend.commissions.create', compact('agents', 'courses', 'currencies'));
    }

    /**
     * Store a newly created commission in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'agent_id'        => 'required|exists:agents,id',
            'course_id'       => 'nullable|exists:courses,id',
            'commission_type' => 'required|in:flat,percentage',
            'amount'          => 'required|numeric|min:0|max:1000000',
            'currency'        => 'required|string|max:10',
        ]);

        // Permission check
        $agent = Agent::findOrFail($validated['agent_id']);
        
        if ($user->hasRole('Master Agent')) {
            // Master Agent can only set commission for self or sub-agents
            if ($agent->id != $user->agent->id && $agent->parent_agent_id != $user->agent->id) {
                abort(403, 'You can only set commission for yourself or your sub-agents.');
            }
        } elseif (!$user->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Duplicate Check
        $existing = AgentCommission::where('agent_id', $validated['agent_id'])
            ->where(function ($q) use ($validated) {
                if ($validated['course_id']) {
                    $q->where('course_id', $validated['course_id']);
                } else {
                    $q->whereNull('course_id');
                }
            })
            ->first();

        if ($existing) {
            return back()
                ->withInput()
                ->with('error', 'Commission already exists for this agent and course. Please edit the existing one.');
        }

        DB::transaction(function () use ($validated) {
            AgentCommission::create([
                'agent_id'        => $validated['agent_id'],
                'course_id'       => $validated['course_id'] ?? null,
                'commission_type' => $validated['commission_type'],
                'amount'          => $validated['amount'],
                'currency'        => $validated['currency'],
            ]);
        });

        return redirect()
            ->route('commissions.index')
            ->with('success', 'Commission setup created successfully!');
    }

    /**
     * Show the form for editing the specified commission.
     */
    public function edit($id)
    {
        $commission = AgentCommission::with('agent', 'course')->findOrFail($id);
        $user = auth()->user();

        // Permission check
        $this->authorizeCommissionAccess($commission, $user);

        $agents = Agent::when(!$user->hasRole('Super Admin'), function ($q) use ($user) {
                if ($user->hasRole('Master Agent')) {
                    $q->where('parent_agent_id', $user->agent->id ?? 0)
                      ->orWhere('id', $user->agent->id);
                } else {
                    $q->where('id', $user->agent->id ?? 0);
                }
            })
            ->where('status', 'active')
            ->select('id', 'name', 'agent_code', 'agent_type')
            ->get();

        $courses = Course::where('status', 'active')
            ->select('id', 'name', 'fee', 'currency')
            ->get();

        $currencies = config('currencies', ['GBP', 'USD', 'BDT', 'SHS', 'AED', 'INR', 'EUR']);

        return view('backend.commissions.edit', compact('commission', 'agents', 'courses', 'currencies'));
    }

    /**
     * Update the specified commission in storage.
     */
    public function update(Request $request, $id)
    {
        $commission = AgentCommission::findOrFail($id);
        $user = auth()->user();

        // Permission check
        $this->authorizeCommissionAccess($commission, $user);

        $validated = $request->validate([
            'agent_id'        => 'required|exists:agents,id',
            'course_id'       => 'nullable|exists:courses,id',
            'commission_type' => 'required|in:flat,percentage',
            'amount'          => 'required|numeric|min:0|max:1000000',
            'currency'        => 'required|string|max:10',
        ]);

        // Duplicate check (excluding current record)
        $existing = AgentCommission::where('agent_id', $validated['agent_id'])
            ->where('id', '!=', $commission->id)
            ->where(function ($q) use ($validated) {
                if ($validated['course_id']) {
                    $q->where('course_id', $validated['course_id']);
                } else {
                    $q->whereNull('course_id');
                }
            })
            ->first();

        if ($existing) {
            return back()
                ->withInput()
                ->with('error', 'Commission already exists for this agent and course.');
        }

        DB::transaction(function () use ($commission, $validated) {
            $commission->update([
                'agent_id'        => $validated['agent_id'],
                'course_id'       => $validated['course_id'] ?? null,
                'commission_type' => $validated['commission_type'],
                'amount'          => $validated['amount'],
                'currency'        => $validated['currency'],
            ]);
        });

        return redirect()
            ->route('commissions.index')
            ->with('success', 'Commission updated successfully!');
    }

    /**
     * Remove the specified commission from storage.
     */
    public function destroy($id)
    {
        $commission = AgentCommission::findOrFail($id);
        $user = auth()->user();

        $this->authorizeCommissionAccess($commission, $user);

        // Check if commission has associated transactions
        $hasTransactions = $commission->agent
            ->masterTransactions()
            ->orWhere('sub_agent_id', $commission->agent_id)
            ->exists();

        if ($hasTransactions) {
            return back()->with('error', 'Cannot delete! This commission has been used in transactions.');
        }

        $commission->delete();

        return back()->with('success', 'Commission deleted successfully!');
    }

    /**
     * Commission access authorization helper
     */
    private function authorizeCommissionAccess($commission, $user)
    {
        if ($user->hasRole('Super Admin')) {
            return; // HQ super admin access
        }

        if ($user->hasRole('Master Agent')) {
            $agentId = $user->agent->id ?? 0;
            // Master Agent can edit own and sub-agent commissions
            if ($commission->agent_id == $agentId) {
                return;
            }
            $subAgentIds = Agent::where('parent_agent_id', $agentId)->pluck('id');
            if ($subAgentIds->contains($commission->agent_id)) {
                return;
            }
        }

        abort(403, 'Unauthorized action.');
    }
}

