<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            abort(403, 'No autenticado');
        }

        $user = auth()->user();

        // Validar que tenga rol cargado
        if (!$user->role || $user->role->nombre !== $role) {
            abort(403, 'No tienes permiso para acceder');
        }

        return $next($request);
    }
}
