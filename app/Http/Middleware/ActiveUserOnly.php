<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveUserOnly
{
    public function handle(Request $request, Closure $next)
{
    // Bypass for login/register
    if ($request->is('/','login', 'register', 'auth/google*', 'lang', 'verify-otp', 'otp/cancel')) {
        return $next($request);
    }

    // Only allow users with status == 0
    if (Auth::check() && Auth::user()->status == 0) {
        return $next($request);
    }

    abort(403, 'Unauthorized - Inactive user');
}


}
