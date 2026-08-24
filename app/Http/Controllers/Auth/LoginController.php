<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const DECAY_SECONDS = 300; // 5 minutes lockout

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle admin login request — hardened version
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|max:254',
            'password' => 'required|string|min:6|max:128',
        ], [
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
        ]);

        // ── Rate limiting (per IP + email combo) ────────────────────────
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            Log::warning('Admin login throttled', [
                'ip'    => $request->ip(),
                'email' => $request->email,
            ]);

            throw ValidationException::withMessages([
                'email' => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $seconds,
                ]),
            ])->status(429);
        }

        // ── Timing-safe credential check ────────────────────────────────
        // Always do the hash check even if admin not found, to prevent
        // timing-based user enumeration attacks.
        $admin = Admin::where('email', $request->email)->first();

        $passwordValid = $admin && Hash::check($request->password, $admin->password);

        if (!$passwordValid || !$admin) {
            RateLimiter::hit($throttleKey, self::DECAY_SECONDS);

            // Log suspicious failed attempts
            Log::warning('Admin login failed', [
                'ip'    => $request->ip(),
                'email' => $request->email,
                'ua'    => $request->userAgent(),
            ]);

            // Generic message — never reveal whether the email exists
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        // ── Account active check ─────────────────────────────────────────
        if (!$admin->is_active) {
            RateLimiter::hit($throttleKey, self::DECAY_SECONDS);

            Log::warning('Login attempt on deactivated admin account', [
                'email' => $request->email,
                'ip'    => $request->ip(),
            ]);

            // Still generic to avoid confirming the account exists
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        // ── Success ──────────────────────────────────────────────────────
        RateLimiter::clear($throttleKey);

        Auth::guard('admin')->login($admin, $request->filled('remember'));

        $admin->updateLastLogin();

        // Prevent session fixation
        $request->session()->regenerate();

        Log::info('Admin login successful', [
            'admin_id' => $admin->id,
            'email'    => $admin->email,
            'ip'       => $request->ip(),
        ]);

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Welcome back, ' . $admin->name . '!');
    }

    /**
     * Handle admin logout request
     */
    public function logout(Request $request)
    {
        $adminId = Auth::guard('admin')->id();

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Admin logout', ['admin_id' => $adminId, 'ip' => $request->ip()]);

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Build a unique throttle key from IP + normalised email
     */
    private function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}