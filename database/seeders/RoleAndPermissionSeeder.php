<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    private function getName($name)
    {
        return [
            "$name view",
            "$name add",
            "$name edit",
            "$name delete",
        ];
    }

    /**
     * Run the database seeds.
     */
    // database/seeders/RoleAndPermissionSeeder.php
    public function run()
    {

        // Permissions
        $permissions = [
            ...$this->getName('campus'),
            ...$this->getName('user'),
            ...$this->getName('permission'),
            ...$this->getName('role'),
            ...$this->getName('agent'),
            ...$this->getName('commission'),
            ...$this->getName('course'),
            ...$this->getName('institute'),
            ...$this->getName('preassessment'),
            ...$this->getName('student'),
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Roles & Assign Permissions
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $campusAdmin = Role::create(['name' => 'Campus Head']);
        $campusAdmin->givePermissionTo(['campus view', 'user add', 'user view', 'user edit', 'user delete', 'role view']);

        $staff = Role::create(['name' => 'HQ Admin Staff']);
        $staff->givePermissionTo(['campus view']);

        $staff = Role::create(['name' => 'Campus Staff']);
        $staff->givePermissionTo(['campus view']);

        $student = Role::create(['name' => 'Student']);
        // No permissions needed for Student role in the admin panel

        $staff = Role::create(['name' => 'Stake Holders']);
        $staff->givePermissionTo(['']);

    }
}
