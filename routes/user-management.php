<?php

use App\Http\Controllers\Admin\User_Management\PermissionController;
use App\Http\Controllers\Admin\User_Management\RoleController;
use App\Http\Controllers\Admin\User_Management\UserController;
use App\Http\Controllers\Admin\User_Management\UserProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are intended for an admin panel where all data is fetched
| and manipulated via AJAX requests. They return JSON responses.
|
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    //** User Management **
    // Accessible via URLs like: /admin/users
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // Get all users for a data table
        Route::post('/', 'store')->name('store'); // Create a new user
        Route::get('/{user}/show', 'show')->name('show'); // Get a single user's data for editing
        Route::get('/{user}', 'edit')->name('edit'); // Update a user's details
        Route::put('/{user}', 'update')->name('update'); // Update a user's details
        Route::delete('/{user}', 'destroy')->name('destroy'); // Delete a user
        Route::post('/{user}/roles', 'assignRoles')->name('assign.roles'); // Assign roles to a user
        Route::post('/assign-roles', 'assignRoles')->name('admin.users.assignRoles');

        Route::post('/status/{id}', 'changeStatus')->name('users.changeStatus');

        Route::post('/account/update', 'userAccountUpdate')->name('user.account.update');
    });
    //** Role Management **
    // // Accessible via URLs like: /admin/roles
    Route::prefix('roles')->name('roles.')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // Get all roles
        Route::post('/', 'store')->name('store'); // Create a new role
        Route::get('/{role}/show', 'show')->name('show'); // Get a single role's data
        Route::put('/{role}', 'update')->name('update'); // Update a role
        Route::delete('/{role}', 'destroy')->name('destroy'); // Delete a role
        Route::post('/{role}/permissions', 'assignPermissions')->name('assign.permissions'); // Assign permissions to a role
    });
        
    // //** Permission Management **
    // // Accessible via URLs like: /admin/permissions
    Route::prefix('permissions')->name('permissions.')->controller(PermissionController::class)->group(function () {
        // Typically, you only need to list permissions as they are often defined in code.
        Route::get('/', 'index')->name('index'); // Get all available permissions
    });

    // User Profile
    Route::prefix('user-profile')->name('user-profile.')->controller(UserProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // View user profile page
        Route::get('/show-profile', 'showProfile')->name('showProfile'); // Get the currently authenticated user's profile
        Route::get('/data', 'getUserDetails')->name('show.profile.data'); 
        Route::post('/change-password', 'updatePassword')->name('change.passsword.store'); 
        Route::get('/activity-logs', 'activityLogs')->name('activity.logs.view'); 
    });

    // user profile notification settings
    Route::prefix('notification-settings')->name('notification.')->controller(UserController::class)->group(function () {
        Route::post('/save', 'saveNotificationSettings')->name('settings.save'); 
        Route::get('/get', 'getUserSettings')->name('settings.get'); 
    });

        // two factor auth
    Route::prefix('two-factor-auth')->name('two-factor.')->controller(UserController::class)->group(function () {
        Route::post('/save', 'createOrUpdateTwoFactorAuth')->name('auth.save'); 
    });

    Route::prefix('notification-preferences')->name('notification.')->controller(UserController::class)->group(function () {
        Route::post('/save', 'storeNotificationPreference')->name('preferences.save'); 
        Route::get('/get', 'getNotificationPreferences')->name('preferences.get'); 
    });

});