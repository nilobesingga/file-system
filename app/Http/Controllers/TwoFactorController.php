<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class TwoFactorController extends Controller
{
    public function enable(Request $request, EnableTwoFactorAuthentication $enable2FA)
    {
        $enable2FA($request->user());
        return redirect()->route('profile.edit')->with('status', 'two-factor-authentication-enabled');
    }

    public function confirm(Request $request, ConfirmTwoFactorAuthentication $confirm2FA)
    {
        $request->validate(['code' => 'required']);
        $confirm2FA($request->user(), $request->code);
        return redirect()->route('profile.edit')->with('status', 'two-factor-authentication-confirmed');
    }
    public function disable2FA(Request $request)
    {
        $user = $request->user();
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->save();
        $request->session()->remove('two_factor_verified');
        return redirect()->route('profile.edit')->with('status', '2fa-disabled');
    }

    public function show()
    {
        return view('auth.two-factor-challenge');
    }

    public function verify(Request $request, ConfirmTwoFactorAuthentication $confirm2FA)
    {
        $request->validate(['code' => 'required|string|min:6|max:6']);
        $code = $request->code;
        $user = Auth::user();

        try {
            $confirm2FA($user, $code);
            $request->session()->put('two_factor_verified', true);
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return back()->withErrors(['code' => 'Invalid 2FA code: ' . $e->getMessage()]);
        }
    }
}
