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
            return redirect()->route('sponsor.login')
                ->with('error', 'Your account has been deactivated. Please contact us.');
        }

        return $next($request);
    }
}
