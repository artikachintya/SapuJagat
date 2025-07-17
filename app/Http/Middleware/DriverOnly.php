<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DriverOnly
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 3) {
            return $next($request);
        }

        abort(403, 'Unauthorized - Driver Only');
    }
}
