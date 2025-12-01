<?php

namespace App\Http\Controllers\Admin\User_Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::withCount('users')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('users_count', function ($row) {
                    return '<span class="badge bg-light text-dark">' . $row->users_count . ' users</span>';
                })
                ->addColumn('action', function ($row) {
                    if ($row->name === 'Super Admin') {
                        return '';
                    }
                    $btn = '<div class="action-btn-group">';
                    $btn .= '<a href="javascript:void(0)" class="action-btn-success me-1 edit-role" data-id="' . $row->id . '" title="Edit"><i class="bx bxs-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="action-btn-danger delete-role" data-id="' . $row->id . '" title="Delete"><i class="bx bxs-trash"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['users_count', 'action'])
                ->make(true);
        }
        
        // Return the user management view with roles tab active
        return redirect()->route('admin.users.index')->with('activeTab', 'gs-2');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => 'Role created successfully.']);
    }

    public function show($id)
    {
        $role = Role::with('permissions')->find($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return response()->json(['success' => 'Role updated successfully.']);
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        return response()->json(['success' => 'Role deleted successfully.']);
    }

    public function assignPermissions(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissionIds = $request->input('permissions', []);

        // Get permission names from IDs
        $permissions = Permission::whereIn('id', $permissionIds)
            ->where('guard_name', 'web')
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissions);

        return response()->json(['success' => 'Permissions updated successfully.']);
    }

    public function assignRoles(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,id', // single role
        ]);

        $user = User::findOrFail($request->user_id);

        // Fetch the role name from ID
        $roleName = Role::where('id', $request->role)->value('name');

        // Assign the single role
        $user->syncRoles([$roleName]); // pass as array

        return response()->json(['success' => 'Role assigned successfully.']);
    }

}
