<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Create a test user if not exists
$email = 'testlogin@example.com';
$username = 'testlogin';
$password = 'password123';

$user = User::where('email', $email)->first();
if (!$user) {
    $user = User::create([
        'name' => 'Test Login User',
        'username' => $username,
        'email' => $email,
        'password' => bcrypt($password),
        'is_active' => true,
    ]);
    echo "Created user: $email / $username\n";
} else {
    // Reset password to be sure
    $user->password = bcrypt($password);
    $user->save();
    echo "Reset password for user: $email / $username\n";
}

// Test login with username
echo "Testing login with username: $username ... ";
if (Auth::attempt(['username' => $username, 'password' => $password])) {
    echo "SUCCESS\n";
    Auth::logout();
} else {
    echo "FAILED\n";
}

// Test login with email
echo "Testing login with email: $email ... ";
if (Auth::attempt(['email' => $email, 'password' => $password])) {
    echo "SUCCESS\n";
    Auth::logout();
} else {
    echo "FAILED\n";
}

// Test LoginRequest logic simulation
$input = $email;
$field = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
echo "LoginRequest logic for input '$input' -> field '$field' ... ";
if (Auth::attempt([$field => $input, 'password' => $password])) {
    echo "SUCCESS\n";
    Auth::logout();
} else {
    echo "FAILED\n";
}

$input = $username;
$field = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
echo "LoginRequest logic for input '$input' -> field '$field' ... ";
if (Auth::attempt([$field => $input, 'password' => $password])) {
    echo "SUCCESS\n";
    Auth::logout();
} else {
    echo "FAILED\n";
}
