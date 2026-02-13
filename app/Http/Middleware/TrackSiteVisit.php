<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SiteVisit;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;

class TrackSiteVisit
{
    /**
     * Handle an incoming request.
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

            // Get IP address
            $ipAddress = $this->getClientIp($request);
            
            // Get location data (country, city)
            $locationData = $this->getLocationFromIp($ipAddress);

            // Track the visit
            SiteVisit::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'page_url' => $request->fullUrl(),
                'referrer' => $request->header('referer'),
                'device_type' => $deviceType,
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'country' => $locationData['country'] ?? null,
                'city' => $locationData['city'] ?? null,
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

    /**
     * Get location data from IP address
     */
    protected function getLocationFromIp(string $ip): array
    {
        // Skip localhost and private IPs
        if ($this->isPrivateIp($ip)) {
            return [
                'country' => 'Local',
                'city' => 'Development',
            ];
        }

        try {
            // Option 1: Using ip-api.com (Free, no API key required)
            // Limit: 45 requests per minute
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'success') {
                    return [
                        'country' => $data['country'] ?? null,
                        'city' => $data['city'] ?? null,
                    ];
                }
            }

            // Option 2: Fallback to ipapi.co (Free tier: 1000 requests/day)
            // $response = Http::timeout(3)->get("https://ipapi.co/{$ip}/json/");
            // if ($response->successful()) {
            //     $data = $response->json();
            //     return [
            //         'country' => $data['country_name'] ?? null,
            //         'city' => $data['city'] ?? null,
            //     ];
            // }

            // Option 3: Using GeoIP2 Database (Requires MaxMind database)
            // See implementation below for local database option
            
        } catch (\Exception $e) {
            Log::warning("Failed to get location for IP {$ip}: " . $e->getMessage());
        }

        return [
            'country' => null,
            'city' => null,
        ];
    }

    /**
     * Check if IP is private/local
     */
    protected function isPrivateIp(string $ip): bool
    {
        // Localhost
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return true;
        }

        // Private IP ranges
        $privateRanges = [
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
        ];

        foreach ($privateRanges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if IP is in range
     */
    protected function ipInRange(string $ip, string $range): bool
    {
        list($subnet, $mask) = explode('/', $range);
        
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = ~((1 << (32 - $mask)) - 1);
        
        return ($ip & $mask) === ($subnet & $mask);
    }
}