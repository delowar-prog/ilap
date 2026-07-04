<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('name')->paginate(15);

        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:permissions,name',
            ],
        ], [
            'name.unique' => 'This permission already exists.',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()
             ->route('permissions.index')
            ->with('success', 'New permission created successfully.');
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
    public function destroy(Permission $permission)
    {
        // Check if this permission is currently assigned to any roles
        $rolesUsingPermission = Role::permission($permission)->count();
        
        if ($rolesUsingPermission > 0) {
            return redirect()
                ->route('permissions.index')
                ->with('error', 'This permission cannot be deleted because it is currently assigned to ' . $rolesUsingPermission . ' role(s).');
        }

        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}

