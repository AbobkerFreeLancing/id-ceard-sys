<?php

namespace App\Http\Middleware;

use App\Jobs\ProductHasExpiredJob;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdminQueue
{

public function handle($request, Closure $next)
  {
    if(1==15) {
      ProductHasExpiredJob::dispatch();
    }

    return $next($request);
  }
}
