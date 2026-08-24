<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SponsorAuthController extends Controller
{
    private const MAX_ATTEMPTS   = 5;
    private const DECAY_SECONDS  = 300; // 5-minute lockout

    public function showLogin()
    {
        if (Auth::guard('sponsor')->check()) {
            return redirect()->route('sponsor.dashboard');
        }

        $settings = $this->getCachedSettings();
        return view('sponsor.login', compact('settings'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:254',
            'password' => 'required|string|min:6|max:128',
        ]);

        // ── Rate limiting by IP ──────────────────────────────────────────
        $key = 'sponsor-login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($key);

            Log::warning('Sponsor login throttled', [
                'ip'       => $request->ip(),
                'username' => $request->username,
            ]);

            return redirect()->route('sponsor.login.locked', ['seconds' => $seconds]);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::guard('sponsor')->attempt($credentials, $request->filled('remember'))) {
            RateLimiter::clear($key);

            $sponsor = Auth::guard('sponsor')->user();
            $sponsor->update(['last_login_at' => now()]);

            // Prevent session fixation
            $request->session()->regenerate();

            Log::info('Sponsor login successful', [
                'sponsor_id' => $sponsor->id,
                'ip'         => $request->ip(),
            ]);

            return redirect()->intended(route('sponsor.dashboard'));
        }

        RateLimiter::hit($key, self::DECAY_SECONDS);

        Log::warning('Sponsor login failed', [
            'ip'       => $request->ip(),
            'username' => $request->username,
            'ua'       => $request->userAgent(),
        ]);

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            return redirect()->route('sponsor.login.locked', ['seconds' => self::DECAY_SECONDS]);
        }

        $remainder = self::MAX_ATTEMPTS - RateLimiter::attempts($key);

        return back()->withErrors([
            'username' => "Invalid credentials. {$remainder} attempt(s) remaining.",
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $sponsorId = Auth::guard('sponsor')->id();

        Auth::guard('sponsor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Sponsor logout', ['sponsor_id' => $sponsorId, 'ip' => $request->ip()]);

        return redirect()->route('sponsor.login')->with('success', 'Logged out successfully.');
    }

    public function showLocked(Request $request)
    {
        $seconds  = (int) $request->query('seconds', self::DECAY_SECONDS);
        $settings = $this->getCachedSettings();

        return response(view('sponsor.login_locked', compact('seconds', 'settings')), 429);
    }

    private function getCachedSettings(): array
    {
        return Cache::remember('site_settings_json', 3600, function () {
            $path = storage_path('app/settings.json');
            return file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        });
    }
}
