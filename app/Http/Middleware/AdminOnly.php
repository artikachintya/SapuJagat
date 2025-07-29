<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return $next($request);
        }

        $roleId = Auth::check() ? Auth::user()->role : null;
        $roleName = $this->getRoleName($roleId);

        activity('unauthorized_access')
            ->causedBy(Auth::check() ? Auth::user() : null)
            ->withProperties([
                'attempted_url' => $request->fullUrl(),
                'role' => $roleName,
            ])
            ->log('Akses ditolak: halaman khusus admin');

        abort(403, 'Unauthorized - Admin Only');
    }

    private function getRoleName($roleId)
    {
        return match ($roleId) {
            1 => 'user',
            2 => 'admin',
            3 => 'driver',
            default => 'guest',
        };
    }
}
