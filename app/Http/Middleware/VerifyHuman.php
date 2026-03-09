<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyHuman
{
        private array $except = [
        'verify-human',
        'verify-human/submit',
        'admin/*',
        'sponsor/login',
        'sponsor/logout',
        'api/*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Skip on exempt routes
        if ($this->isExcluded($request)) {
            return $next($request);
        }

        // Already verified this session — let through
        if (session('human_verified') === true) {
            return $next($request);
        }

        // Not verified — store intended URL and redirect to gate
        session(['intended_url' => $request->fullUrl()]);

        return redirect()->route('verify.human');
    }

    private function isExcluded(Request $request): bool
    {
        foreach ($this->except as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }
        return false;
    }

}
