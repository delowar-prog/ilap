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
     * পারমিশন অ্যাসাইনমেন্ট ফর্ম দেখানো
     */
    public function editPermissions(Role $role)
    {
        // সুপার এডমিনের পারমিশন এডিট করা যাবে না
        // if ($role->name === 'Super Admin') {
        //     return redirect()
        //         ->route('roles.index')
        //         ->with('error', 'সুপার এডমিনের পারমিশন এডিট করা যাবে না।');
        // }

        $allPermissions = Permission::all()->groupBy(function ($permission) {
            // পারমিশন নাম থেকে গ্রুপ তৈরি (যেমন: 'campus view' -> 'campus')
            return explode(' ', $permission->name)[0] ?? 'general';
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.edit', compact('role', 'allPermissions', 'rolePermissions'));
    }

    /**
     * পারমিশন আপডেট করা
     */
    public function updatePermissions(Request $request, Role $role)
    {
        // সুপার এডমিনের পারমিশন আপডেট ব্লক
        // if ($role->name === 'Super Admin') {
        //     return redirect()
        //         ->route('roles.index')
        //         ->with('error', 'সুপার এডমিনের পারমিশন পরিবর্তন করা যাবে না।');
        // }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        DB::transaction(function () use ($role, $request) {
            // আগের সব পারমিশন রিমুভ করে নতুন পারমিশন সেট করা
            $role->syncPermissions($request->permissions ?? []);
        });

        return redirect()
            ->route('roles.index')
            ->with('success', 'পারমিশন সফলভাবে আপডেট করা হয়েছে।');
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
