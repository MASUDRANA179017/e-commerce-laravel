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
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
            'permissions.assign',
            'projects.view', 'projects.create', 'projects.edit', 'projects.delete',
            'tasks.view', 'tasks.create', 'tasks.edit', 'tasks.delete',
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create a Super Admin Role
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        // A Super Admin gets all permissions.
        $superAdminRole->givePermissionTo(Permission::all());

        // Create a Super Admin User
        $superAdminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'username' => 'superadmin',
            'password' => bcrypt('password'), // Change this!
            'status' => 'active',
        ]);
        $superAdminUser->assignRole($superAdminRole);
        
        // Create an Admin Role
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(['dashboard.view', 'users.view', 'projects.view', 'tasks.view']);
        
        // Create a regular user
         $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => bcrypt('password'), // Change this!
            'status' => 'active',
        ]);
        $user->assignRole('Admin');
    }
}