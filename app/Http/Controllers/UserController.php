<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $query = User::with('campus')
            // 1. Branch resolution: filter by campus if not Super Admin
            ->when(! $isSuperAdmin, fn ($q) => $q->where('campus_id', $user->campus_id))

            // 2. Search filter
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('user_first_name', 'like', "%{$search}%")
                        ->orWhere('user_last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })

            // 3. Campus filter for Super Admin
            ->when($isSuperAdmin && request('campus_id'), fn ($q) => $q->where('campus_id', request('campus_id')))

            // 4. Role filter
            ->when(request('role'), fn ($q) => $q->role(request('role')))

            // 5. Status filter
            ->when(request('status'), fn ($q) => $q->where('status', request('status')));

        $sortDir = request('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $users = $query->orderBy('id', $sortDir)->paginate(request('per_page', 10))->withQueryString();

        // Fetch data for dropdowns
        $campuses = Campus::where('status', 'active')->select('id', 'name')->get();
        $roles = Role::where('name', '!=', 'Super Admin')->select('id', 'name')->get();

        return view('backend.users.index', compact('users', 'campuses', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = auth()->user();
        $isPrivilegedUser = $currentUser->hasRole('Super Admin') || $currentUser->hasRole('HQ Admin');

        // Branch filtering
        $campusesQuery = Campus::where('status', 'active');

        if (! $isPrivilegedUser) {
            $campusesQuery->where('id', $currentUser->campus_id);
        }

        $campuses = $campusesQuery->orderBy('name')->get();

        // Role filtering
        $rolesQuery = Role::query();

        if ($isPrivilegedUser) {
            // Super Admin/HQ Admin: all roles except Super Admin
            $rolesQuery->where('name', '!=', 'Super Admin');
        } else {
            // Branch user: allowed branch roles
            $allowedRoles = ['Campus Admin', 'Staff', 'Student'];
            $rolesQuery->whereIn('name', $allowedRoles);
        }

        $roles = $rolesQuery->orderBy('name')->get();

        return view('backend.users.create', compact('campuses', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Photo upload handling
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('users/photos', 'public');
            }

            // 2. Create user record
            $user = User::create([
                'user_first_name' => $request->user_first_name,
                'user_middle_name' => $request->user_middle_name,
                'user_last_name'  => $request->user_last_name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'photo'           => $photoPath,
                'campus_id'       => $request->campus_id,
                'password'        => Hash::make($request->password),
                'status'          => $request->status,
            ]);

            // 3. Assign role
            $user->assignRole($request->role);
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'User created and role assigned successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
