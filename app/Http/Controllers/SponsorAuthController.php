<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorAuthController extends Controller
{
  public function showLogin()
    {
        if (Auth::guard('sponsor')->check()) {
            return redirect()->route('sponsor.dashboard');
        }

        $settingsFile = storage_path('app/settings.json');
        $settings = file_exists($settingsFile)
        ? json_decode(file_get_contents($settingsFile), true)
        : [];
        return view('sponsor.login', compact('settings'));
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Rate limiting: max 5 attempts per minute
        $key = 'sponsor-login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'username' => "Too many login attempts. Please try again in {$seconds} seconds."
            ]);
        }

        $credentials = $request->only('username', 'password');
        
        if (Auth::guard('sponsor')->attempt($credentials, $request->filled('remember'))) {
            RateLimiter::clear($key);
            
            // Update last login
            $sponsor = Auth::guard('sponsor')->user();
            $sponsor->update(['last_login_at' => now()]);

            $request->session()->regenerate();
            return redirect()->intended(route('sponsor.dashboard'));
        }
        

        RateLimiter::hit($key, 60);
        
        return back()->withErrors([
            'username' => 'Invalid credentials.',
        ])->onlyInput('username');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('sponsor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('sponsor.login')->with('success', 'Logged out successfully.');
    }
}
