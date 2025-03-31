<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        $user = Auth::user();
        return view('auth.change-password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('id',Auth::user()->id)->first();

         // Check if the provided current password matches the stored password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        // Prevent reusing the same password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Your new password must be different from the current password.']);
        }

        $user->password = Hash::make($request->password);
        $user->force_password_change = 1; // Assuming this field exists to track password change requirement
        $user->password_changed_at = date('Y-m-d H:i:s'); // Assuming this field exists to track password change time
        $user->save();
        event(new Registered($user));

        Auth::login($user);
        return redirect()->route('dashboard')->with('status', 'Password changed successfully.');
    }
}
