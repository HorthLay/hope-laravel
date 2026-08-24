<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('sponsor')->check()) {
            return redirect()->route('sponsor.login')
                ->with('error', 'Please log in to access your sponsorship area.');
        }

        // Check if sponsor account is active
        $sponsor = Auth::guard('sponsor')->user();
        if (!$sponsor->is_active) {
            Auth::guard('sponsor')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('sponsor.login')
                ->with('error', 'Your account has been deactivated. Please contact us.');
        }

        // ── Session fingerprint: detect session hijacking ────────────────
        // We create a fingerprint on first access and re-verify on every request.
        $fingerprint = hash('sha256', $request->userAgent() . '|' . $request->ip());
        $stored      = $request->session()->get('_sponsor_fp');

        if (!$stored) {
            // First request — store fingerprint
            $request->session()->put('_sponsor_fp', $fingerprint);
        } elseif (!hash_equals($stored, $fingerprint)) {
            // Fingerprint mismatch — possible session hijacking
            Auth::guard('sponsor')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('sponsor.login')
                ->with('error', 'Your session has expired. Please log in again.');
        }

        return $next($request);
    }
}
