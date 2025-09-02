<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

class EmployeeLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.employee-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('employee')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended('/attendance');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput($request->only('email'));
    }


    public function logout(Request $request)
    {
        Auth::guard('employee')->logout(); // logout employee guard

        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }


public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed', // confirmed = new_password_confirmation field required
    ]);

    $user = auth()->user();

    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Old password is incorrect.']);
    }

    $user->password = Hash::make($request->new_password);
    $user->is_password_update = true; // status update
    $user->save();

    return redirect()->route('attendance.index')->with('success', 'Password updated successfully.');
}

}
