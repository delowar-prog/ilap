<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);

        return view('backend.roles.index', compact('roles'));
    }

    /**
     * Show permission assignment form
     */
    public function editPermissions(Role $role)
    {
        $allPermissions = Permission::all()->groupBy(function ($permission) {
            // Group permissions by prefix (e.g. 'campus view' -> 'campus')
            return explode(' ', $permission->name)[0] ?? 'general';
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.edit', compact('role', 'allPermissions', 'rolePermissions'));
    }

    /**
     * Update permissions for role
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        DB::transaction(function () use ($role, $request) {
            // Sync new permissions with role
            $role->syncPermissions($request->permissions ?? []);
        });

        return redirect()
            ->route('roles.index')
            ->with('success', 'Permissions updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
