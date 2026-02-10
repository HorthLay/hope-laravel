<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
  public function showLoginForm()
    {
        // Redirect if already authenticated as admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle admin login request
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        // Find admin by email
        $admin = Admin::where('email', $request->email)->first();

        // Check if admin exists
        if (!$admin) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        // Check if password matches
        if (!Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'password' => 'The password is incorrect.',
            ]);
        }

        // Check if admin is active
        if (!$admin->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Your account has been deactivated. Please contact administrator.',
            ]);
        }

        // Log the admin in using admin guard
        Auth::guard('admin')->login($admin, $request->filled('remember'));

        // Update last login timestamp
        $admin->updateLastLogin();

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        // Redirect to admin dashboard
        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Welcome back, ' . $admin->name . '!');
    }

    /**
     * Handle admin logout request
     */
    public function logout(Request $request)
    {
        // Logout admin
        Auth::guard('admin')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}