<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        log::info('Login attempt for user: ' . json_encode($request));
        $request->authenticate();

        $request->session()->regenerate();
         activity() // start activity log
        ->causedBy(auth()->user())        // who did it
        ->performedOn(auth()->user())      // model instance
        ->withProperties(['title' => 'login']) // extra data
        ->log('User logged in'); 
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        activity() // start activity log
    ->causedBy(auth()->user())        // who did it
    ->performedOn(auth()->user())      // model instance
    ->withProperties(['title' => 'logout']) // extra data
    ->log('User logged in');
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        

        return redirect('/');
    }
}
