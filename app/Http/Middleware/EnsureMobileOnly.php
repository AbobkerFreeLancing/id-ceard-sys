<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');

        $isMobile = preg_match('/(android|iphone|ipad|mobile)/i', $userAgent);

        if (!$isMobile) {
            abort(403, 'هذا الرابط متاح فقط عبر تطبيقات الجوال (Android/iOS).');
        }

        return $next($request);
    }
}