<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdminLocalization
{

public function handle($request, Closure $next)
  {
     $local = auth()->user() ? auth()->user()->lang : 'ar';
     app()->setLocale($local);
    return $next($request);
  }
}
