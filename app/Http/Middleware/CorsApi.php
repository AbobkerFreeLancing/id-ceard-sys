<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CorsApi
{

public function handle($request, Closure $next)
    {
        return $next($request)->header('Access-Control-Allow-Origin', '*');
    }
}
