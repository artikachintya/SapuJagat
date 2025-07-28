<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PenggunaOnly
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 1) {
            return $next($request);
        }

        abort(403, 'Unauthorized - Pengguna Only');

        activity('unauthorized_access')
            ->causedBy(Auth::user())
            ->withProperties([
                'attempted_url' => $request->fullUrl(),
                'role' => Auth::user()->role ?? 'guest',
            ])
            ->log('User mencoba mengakses halaman khusus pengguna');

        abort(403, 'Unauthorized - Pengguna Only');
    }
}
