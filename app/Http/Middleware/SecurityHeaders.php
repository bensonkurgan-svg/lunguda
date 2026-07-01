<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Content Security Policy. Google Fonts + jsDelivr (Alpine fallback) +
        // OpenStreetMap tiles for the monuments map are explicitly allowed.
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-eval' 'unsafe-inline' https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://unpkg.com",
            "font-src 'self' https://fonts.gstatic.com data:",
            "img-src 'self' data: https://*.tile.openstreetmap.org https://unpkg.com",
            "media-src 'self' blob:",
            "connect-src 'self'",
            "frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');
        $response->headers->set('X-XSS-Protection', '0');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
