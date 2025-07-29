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

        $user = Auth::user();
        $roleId = $user->role ?? null;
        $roleName = $this->getRoleName($roleId);

        activity('unauthorized_access')
            ->causedBy($user)
            ->withProperties([
                'attempted_url' => $request->fullUrl(),
                'role' => $roleName,
            ])
            ->log('Akses ditolak: halaman khusus driver');

        abort(403, 'Unauthorized - Driver Only');
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
