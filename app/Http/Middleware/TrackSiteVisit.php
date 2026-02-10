<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Http\Request;
use App\Models\SiteVisit;
use Illuminate\Support\Facades\Log;
// use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class TrackSiteVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        // Don't track admin routes or API routes
        if ($request->is('admin/*') || $request->is('api/*')) {
            return $next($request);
        }

        // Don't track bots and crawlers (optional)
        $userAgent = $request->userAgent();
        $botPatterns = ['bot', 'crawler', 'spider', 'scraper'];
        
        foreach ($botPatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return $next($request);
            }
        }

        try {
            // Use Agent library to detect device, browser, platform
            $agent = new Agent();
            $agent->setUserAgent($userAgent);

            // Determine device type
            $deviceType = 'desktop';
            if ($agent->isMobile()) {
                $deviceType = 'mobile';
            } elseif ($agent->isTablet()) {
                $deviceType = 'tablet';
            }

            // Track the visit
            SiteVisit::create([
                'ip_address' => $this->getClientIp($request),
                'user_agent' => $userAgent,
                'page_url' => $request->fullUrl(),
                'referrer' => $request->header('referer'),
                'device_type' => $deviceType,
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'visited_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Silently fail - don't break the application
            Log::error('Failed to track site visit: ' . $e->getMessage());
        }

        return $next($request);
    }

    /**
     * Get the real client IP address
     */
    protected function getClientIp(Request $request): string
    {
        // Check for proxy headers
        $ip = $request->header('X-Forwarded-For');
        
        if ($ip) {
            // X-Forwarded-For can contain multiple IPs
            $ips = explode(',', $ip);
            return trim($ips[0]);
        }

        return $request->ip();
    }
}
