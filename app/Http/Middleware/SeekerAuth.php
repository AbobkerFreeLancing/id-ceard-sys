<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeekerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('seekers')->check()) {
            return redirect()->route('filament.seeker.auth.login');
        }

        return $next($request);
    }
}
