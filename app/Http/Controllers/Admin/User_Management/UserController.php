<?php

namespace App\Http\Controllers\Admin\User_Management;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\NotificationPreference;
use App\Models\NotificationSetting;
use App\Models\TwoFactorAuthentication;
use App\Models\User;
use App\Models\UserRecovery;
use App\Models\UserSocialInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with('roles', 'departmentname', 'designationname')->latest();

            // Apply search filter if customSearch exists
            if ($request->filled('customSearch')) {
                $search = $request->customSearch;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // Apply role filter if role_id exists
            if ($request->filled('roleId')) {
                $query->whereHas('roles', function ($q) use ($request) {
                    $q->where('id', $request->roleId);
                });
            }

            // Apply status filter if status exists
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_info', function ($row) {
                    $avatar = $row->avatar ? asset('storage/' . $row->avatar) : asset('assets/img/avatar-1.jpg');
                    return '<div class="d-flex align-items-center">

                            <div>
                                <div class="fw-bold">' . htmlspecialchars($row->name) . '</div>
                                <div class="text-muted small">@' . htmlspecialchars($row->username) . '</div>
                            </div>
                        </div>';
                })
                ->addColumn('contact', function ($row) {
                    return '<div>' . htmlspecialchars($row->email) . '</div>
                        <div class="text-muted small">' . htmlspecialchars($row->phone ?? 'N/A') . '</div>';
                })
                ->addColumn('roles', function ($row) {
                    return $row->roles->map(function ($role) {
                        return '<span class="qbit-badge-primary">' . htmlspecialchars($role->name) . '</span>';
                    })->implode(' ');
                })

                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                })
                ->addColumn('department', function ($row) {
                    return $row->department ? $row->departmentname->name : 'N/A';
                })

                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<button type="button" class="btn btn-sm btn-outline-primary edit-user" data-id="' . $row->id . '" title="Edit">';
                    $btn .= '<i class="bx bxs-edit"></i>';
                    $btn .= '</button>';
                    $btn .= '<button type="button" class="btn btn-sm btn-outline-danger delete-user" data-id="' . $row->id . '" title="Delete">';
                    $btn .= '<i class="bx bxs-trash"></i>';
                    $btn .= '</button>';
                    $btn .= '</div>';
                    return $btn;
                })


                ->rawColumns(['user_info', 'contact', 'roles', 'status', 'department', 'action'])
                ->make(true);
        }

        // Fetch departments and designations for dropdowns / forms
        $departments = Department::get();
        $designations = Designation::get();
        $roles = Role::get();
        $users = User::get();

        return view('admin.user_management.manage-user', compact('departments', 'designations', 'roles', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'phone'         => 'nullable|string|max:20',
            'password'      => 'required|string|min:8|confirmed',
            'department'    => 'nullable|string|max:255',
            'designation'   => 'nullable|string|max:255',
            'role'          => 'required|exists:roles,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle image upload
        $avatarPath = null;
        if ($request->hasFile('profile_image')) {

            $avatarPath = uploadFile($request->file('profile_image'), 'users/images');
        }

        // Create user
        $user = User::create([
            'name'        => $request->full_name,
            'username'    => $request->username,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'department'  => $request->department,   // ✅ plain column
            'designation' => $request->designation,  // ✅ plain column
            'address'     => $request->address,
            'status'      => $request->status ?? 1,
            'image'      => $avatarPath,
            'password'    => Hash::make($request->password),
        ]);

        // Assign Role
        $role = Role::find($request->role);
        if ($role) {
            $user->assignRole($role->name);
        }

        return response()->json(['success' => 'User created successfully.']);
    }



    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'username'      => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'      => 'nullable|string|min:8|confirmed',
            'department'    => 'nullable|string|max:255',
            'designation'   => 'nullable|string|max:255',
            'role'          => 'required|exists:roles,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $avatarPath = $user->image;

        if ($request->hasFile('profile_image')) {
            if ($user->avatar && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $avatarPath = uploadFile($request->file('profile_image'), 'users/images');
        }

        // Update user
        $user->update([
            'name'        => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'department'  => $request->department,
            'designation' => $request->designation,
            'address'     => $request->address,
            'status'      => $request->status ?? 1,
            'image'      => $avatarPath,
            'password'    => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Update Role
        $role = Role::find($request->role);
        if ($role) {
            $user->syncRoles([$role->name]);
        }

        return response()->json(['success' => 'User updated successfully.']);
    }



    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     // log::info($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'full_name' => 'required|string|max:255',
    //         'username' => 'nullable|string|max:255|unique:users',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'department' => 'nullable|exists:departments,id',
    //         'designation' => 'nullable|exists:designations,id',
    //         'role' => 'required|exists:roles,id',
    //         'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Handle image upload
    //     $avatarPath = null;
    //     if ($request->hasFile('profile_image')) {
    //         $avatarPath = $request->file('profile_image')->store('avatars', 'public');
    //     }

    //     $user = User::create([
    //         'name' => $request->full_name,
    //         'username' => $request->username,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'department' => $request->department_id,
    //         'designation' => $request->designation_id,
    //         'address' => $request->address,
    //         'status' => $request->status ?? 1,
    //         'image' => $avatarPath,
    //         'password' => Hash::make($request->password),
    //     ]);
    //     // if ($request->hasFile('profile_image')) {
    //     //     $avatarPath = $request->file('profile_image')->store('avatars', 'public');
    //     // }

    //     // Assign Role
    //     $role = Role::find($request->role);
    //     if ($role) {
    //         $user->assignRole($role->name);
    //     }

    //     return response()->json(['success' => 'User created successfully.']);
    // }

    public function show($id)
    {
        $user = User::with('roles','departmentname')->find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['error' => 'User not found.'], 404);
    }


    // public function update(Request $request, $id)
    // {
    //     dd($request->all());
    //     $user = User::findOrFail($id);

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'username' => 'nullable|string|max:255|unique:users,username,' . $id,
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $id,
    //         'roles' => 'required|array',
    //         'password' => 'nullable|string|min:8|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = $request->except('password', 'password_confirmation', 'roles');
    //     if ($request->filled('password')) {
    //         $data['password'] = Hash::make($request->password);
    //     }

    //     $user->update($data);
    //     $user->syncRoles($request->roles);

    //     return response()->json(['success' => 'User updated successfully.']);
    // }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }

    // In App/Http/Controllers/Admin/UserController.php

    public function assignRoles(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,id', // single role
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($request->user_id);

        // Convert role ID to name
        $roleName = Role::where('id', $request->role)->value('name');

        // Assign role
        $user->syncRoles([$roleName]); // must pass as array

        return response()->json(['success' => 'Role assigned successfully.']);
    }

    // status change
    public function changeStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status; // 1 বা 0 আসবে
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }

    public function userAccountUpdate(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',

            'whatsapp' => 'nullable|string|max:255',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'github'   => 'nullable|url',
            'portfolio'=> 'nullable|url',
            'status'   => 'nullable|boolean',

            'recovery_email' => 'nullable|email|max:255',
            'recovery_phone' => 'nullable|string|max:20',
        ]);

        $avatarPath = $user->image; 

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $avatarPath = $request->file('image')->store('avatars', 'public');
        }

        // Update user
        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'image'      => $avatarPath,
            
        ]);

        $userId = Auth::id();

        $socialInfo = UserSocialInfo::updateOrCreate(
            ['user_id' => $userId], // condition
            [
                'whatsapp' => $request->whatsapp,
                'facebook' => $request->facebook,
                'linkedin' => $request->linkedin,
                'github'   => $request->github,
                'portfolio'=> $request->portfolio,
                'status'   => 1,
            ]
        );

        $recovery = UserRecovery::updateOrCreate(
            ['user_id' => $userId],
            [
                'recovery_email' => $request->recovery_email,
                'recovery_phone' => $request->recovery_phone,
                'status'         =>  1,
            ]
        );

        return response()->json([
            'success' => 'User Account Saved Successfully'
        ]);
    }

    public function saveNotificationSettings(Request $request)
    {
        // dd($request->all());
        $userId = Auth::id();

        // Collect all checkboxes as key => value
        $settings = [
            'email_notifications'    => $request->boolean('email_notifications'),
            'push_notifications'     => $request->boolean('push_notifications'),
            'meeting_reminders'      => $request->boolean('meeting_reminders'),
            'task_deadlines'         => $request->boolean('task_deadlines'),
            'financial_updates'      => $request->boolean('financial_updates'),
            'team_activity'          => $request->boolean('team_activity'),
            'system_updates'         => $request->boolean('system_updates'),
            'document_expiry_alerts' => $request->boolean('document_expiry_alerts'),
        ];

        NotificationSetting::updateOrCreate(
            ['user_id' => $userId],
            [
                'settings' => $settings,
                'status'   => 1
            ]
        );

        return response()->json(['success' => 'Notification settings saved successfully', 'settings' => $settings]);
    }

    public function getUserSettings()
    {
        $userId = Auth::id();
        $settings = NotificationSetting::where('user_id', $userId)->first();

        return response()->json([
            'settings' => $settings ? $settings->settings : []
        ]);
    }

    public function createOrUpdateTwoFactorAuth(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'sms_auth' => 'nullable|boolean',
            'email_auth' => 'nullable|boolean',
        ]);

        $tfa = TwoFactorAuthentication::updateOrCreate(
            ['user_id' => $userId],
            [
                'sms_auth' => $request->boolean('sms_auth'),
                'email_auth' => $request->boolean('email_auth'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Two Factor Authentication settings updated.',
            'data' => $tfa
        ]);
    }


    public function storeNotificationPreference(Request $request)
    {
        $validated = $request->validate([
            'notification_frequency' => 'required|in:instant,hourly_digest,daily_digest,weekly_summary',
            'quiet_hours'            => 'nullable|string',
            'notification_channels'  => 'nullable|array',
            'priority_level'         => 'required|in:all,high_priority,critical',
            'notification_sound'     => 'required|in:default,minimal,none',
        ]);

        $preference = NotificationPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'notification_frequency' => $validated['notification_frequency'],
                'quiet_hours'            => $validated['quiet_hours'] ?? null,
                'notification_channels'  => $validated['notification_channels'] ?? [],
                'priority_level'         => $validated['priority_level'],
                'notification_sound'     => $validated['notification_sound'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated successfully.',
            'data'    => $preference,
        ]);
    }

    public function getNotificationPreferences()
    {
        $preference = NotificationPreference::where('user_id', Auth::id())->first();

        return response()->json([
            'success' => true,
            'data' => $preference
        ]);
    }





}
