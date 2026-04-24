<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
       /**
     * Headers to strip from every response
     * (leak server info to attackers)
     */
    private array $removeHeaders = [
        'X-Powered-By',
        'Server',
        'X-Generator',
        'X-Runtime',
        'X-Version',
        'X-AspNet-Version',
        'X-AspNetMvc-Version',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ── 1. Strip info-leaking headers ───────────────────────────────
        foreach ($this->removeHeaders as $header) {
            $response->headers->remove($header);
        }
        header_remove('X-Powered-By'); // also remove from PHP level

        // ── 2. Clickjacking protection ───────────────────────────────────
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // ── 3. MIME-type sniffing protection ─────────────────────────────
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ── 4. XSS protection (legacy browsers) ──────────────────────────
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ── 5. Referrer policy ───────────────────────────────────────────
        // Don't leak your URL path to third-party sites
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ── 6. HSTS — force HTTPS (enable only if you have SSL) ──────────
        // 1 year, include subdomains, submit to preload list
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // ── 7. Permissions Policy ────────────────────────────────────────
        // Block browser features you don't use
        $response->headers->set('Permissions-Policy', implode(', ', [
            'camera=()',
            'microphone=()',
            'geolocation=(self)',   // allow self (for GPS check-in in Attendify)
            'payment=()',
            'usb=()',
            'magnetometer=()',
            'accelerometer=()',
            'gyroscope=()',
            'fullscreen=(self)',
            'picture-in-picture=()',
        ]));

        // ── 8. Content Security Policy ───────────────────────────────────
        // Whitelist only what your app actually loads
        $nonce = base64_encode(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);

        $csp = implode('; ', [
            "default-src 'self'",

            // Scripts: self + CDNs you use
            "script-src 'self' 'nonce-{$nonce}' 'strict-dynamic' " .
                "https://cdn.tailwindcss.com " .
                "https://cdnjs.cloudflare.com " .
                "https://translate.google.com " .
                "https://translate.googleapis.com " .
                "https://www.gstatic.com",

            // Styles: self + Google Fonts + CDNs
            "style-src 'self' 'unsafe-inline' " .    // 'unsafe-inline' needed for Tailwind CDN
                "https://fonts.googleapis.com " .
                "https://cdnjs.cloudflare.com",

            // Fonts
            "font-src 'self' " .
                "https://fonts.gstatic.com " .
                "https://cdnjs.cloudflare.com " .
                "data:",

            // Images: self + flag CDN + data URIs
            "img-src 'self' " .
                "https://flagcdn.com " .
                "https://www.gstatic.com " .
                "data: blob:",

            // Iframes: HelloAsso donation widget
            "frame-src 'self' https://www.helloasso.com",

            // Connections (fetch/XHR/WebSocket)
            "connect-src 'self' " .
                "https://translate.googleapis.com",

            // Forms must post to self only
            "form-action 'self'",

            // No plugins (Flash, Java, etc.)
            "object-src 'none'",

            // Base tag locked to self
            "base-uri 'self'",

            // Block mixed HTTP content
            "upgrade-insecure-requests",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        // ── 9. Cross-Origin policies ─────────────────────────────────────
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-site');
        $response->headers->set('Cross-Origin-Embedder-Policy', 'unsafe-none'); // relaxed for Google Translate iframe

        // ── 10. Cache control for auth pages ─────────────────────────────
        // Prevent browser back-button access after logout
        if ($this->isAuthPage($request)) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }

    private function isAuthPage(Request $request): bool
    {
        return $request->routeIs(
            'sponsor.login',
            'sponsor.login.locked',
            'sponsor.dashboard',
            'sponsor.logout',
            'admin.login',
            'admin.dashboard',
        );
    }
}
