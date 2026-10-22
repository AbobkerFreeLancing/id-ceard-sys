<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    // protected function redirectTo($request)
    // {
    //     if ($request->is('admin') || $request->is('admin/*')) {
    //         return route('filament.admin.auth.login');
    //     }

    //     return route('login');
    // }

    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : Filament::getCurrentPanel()->route('auth.login');
    }
}
