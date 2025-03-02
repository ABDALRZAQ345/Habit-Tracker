<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            $user = Auth::user();
            // handling languages or maybe last login or any thing else that happen in each request
        }

        return $next($request);
    }
}
