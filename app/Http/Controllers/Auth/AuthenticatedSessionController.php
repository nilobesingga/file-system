<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();

        // Check if user is required to change password
        // if ($user && !$user->force_password_change && !$user->is_admin) {
        //     return redirect()->route('change-password');
        // }
        // Check if user is authenticated and has 2FA enabled but not verified
        if ($user && $user->two_factor_secret && !$request->session()->has('two_factor_verified')) {
            return redirect()->route('two-factor.challenge');
        }

        if (Auth::user()->is_admin) {
            // User is an admin, redirect to admin dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        if (!Auth::user()->is_admin && Auth::user()->show_welcome_modal) {
            session(['show_welcome_modal' => true]);
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
