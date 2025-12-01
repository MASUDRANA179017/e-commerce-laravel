<?php

namespace App\Http\Controllers\Admin\User_Management;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        // If AJAX request, return JSON data
        if ($request->ajax() || $request->wantsJson()) {
            // Get all permissions and group them by a "module"
            $allPermissions = Permission::all()->groupBy(function ($permission) {
                // Assumes permission names are like "users.view", "roles.create"
                return explode('.', $permission->name)[0];
            });

            $rolePermissions = [];
            if ($request->has('role_id')) {
                $role = Role::findOrFail($request->role_id);
                $rolePermissions = $role->permissions->pluck('name')->toArray();
            }

            return response()->json([
                'all_permissions' => $allPermissions,
                'role_permissions' => $rolePermissions,
            ]);
        }
        
        // Return the user management view with permissions tab active
        return redirect()->route('admin.users.index')->with('activeTab', 'gs-3');
    }

public function assignPermissions(Request $request, Role $role)
{
    $permissions = $request->input('permissions', []);
    $role->syncPermissions($permissions); // Spatie's magic function to update permissions

    return response()->json(['success' => 'Permissions updated successfully for ' . $role->name]);
}


}

