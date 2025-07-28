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

        activity('unauthorized_access')
            ->causedBy(Auth::user())
            ->withProperties([
                'attempted_url' => $request->fullUrl(),
                'role' => Auth::user()->role ?? 'guest',
            ])
            ->log('User mencoba mengakses halaman khusus driver');

        abort(403, 'Unauthorized - Driver Only');
    }
}
