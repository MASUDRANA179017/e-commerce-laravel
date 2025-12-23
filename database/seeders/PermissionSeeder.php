<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define Permissions
        $permissions = [
            'dashboard.view',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.assign',
            'projects.view',
            'projects.create',
            'projects.edit',
            'projects.delete',
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create a Super Admin Role
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        // A Super Admin gets all permissions.
        $superAdminRole->syncPermissions(Permission::all());

        // Create a Super Admin User
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => bcrypt('password'),
                'is_active' => 1,
            ]
        );
        $superAdminUser->assignRole($superAdminRole);

        // Create an Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions(['dashboard.view', 'users.view', 'projects.view', 'tasks.view']);

        // Create Customer Role
        Role::firstOrCreate(['name' => 'Customer']);

        // Create a regular user
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'username' => 'user',
                'password' => bcrypt('password'),
                'is_active' => 1,
            ]
        );
        $user->assignRole('Customer');
    }
}