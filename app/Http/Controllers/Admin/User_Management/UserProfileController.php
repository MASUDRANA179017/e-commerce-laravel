<?php

namespace App\Http\Controllers\Admin\User_Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Log;
use Spatie\Activitylog\Models\Activity;

class UserProfileController extends Controller
{
    //
    public function index()
    {
        return view('admin.user_management.user_profile');
    }
    public function showProfile(Request $request)
    {
        $user = $request->user(); // Get the currently authenticated user
        return response()->json($user);
    }

    public function getUserDetails(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        // Safely get department and designation if relationships exist
        $department = 'N/A';
        $designation = 'N/A';
        
        if (method_exists($user, 'departmentname') && $user->departmentname) {
            $department = $user->departmentname->name ?? 'N/A';
        }
        
        if (method_exists($user, 'designationname') && $user->designationname) {
            $designation = $user->designationname->title ?? 'N/A';
        }

        // Safely get social info if relationship exists
        $socialInfo = null;
        if (method_exists($user, 'socialInfo')) {
            $socialInfo = $user->socialInfo;
        }

        // Safely get recovery info if relationship exists
        $recovery = null;
        if (method_exists($user, 'recovery')) {
            $recovery = $user->recovery;
        }

        return response()->json([
            'full_name' => $user->name,
            'department' => $department,
            'designation' => $designation,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
            'whatsapp' => $socialInfo->whatsapp ?? '',
            'recovery_email' => $recovery->recovery_email ?? '',
            'recovery_phone' => $recovery->recovery_phone ?? '',
            'facebook' => $socialInfo->facebook ?? '',
            'linkedin' => $socialInfo->linkedin ?? '',
            'github' => $socialInfo->github ?? '',
            'portfolio' => $socialInfo->portfolio ?? '',
            'image' => $user->image ?? '',
            'enlisted_on' => $user->created_at->format('Y-m-d'),
        ]);
    }

    // Controller method
    public function updatePassword(Request $request)
    {
        // log::info('Password change request: ' . json_encode($request->all()));
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->withErrors(['old_password' => 'Old password incorrect']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['success' => 'Password updated successfully']);
    }

    // UserProfileController.php

public function activityLogs(Request $request)
{
    $userId = auth()->id();

    // Get latest 50 activities of this user
    $activities = Activity::where('causer_id', $userId)
                          ->latest()
                          ->take(50)
                          ->get(['created_at', 'description', 'properties']);

    // Format for frontend
    $data = $activities->map(function ($item) {
        return [
            'datetime' => $item->created_at->format('d M Y, h:i A'),
            'activity' => $item->description,
            'status'   => $item->properties['status'] ?? 'N/A', // optional
        ];
    });

    return response()->json($data);
}

}
