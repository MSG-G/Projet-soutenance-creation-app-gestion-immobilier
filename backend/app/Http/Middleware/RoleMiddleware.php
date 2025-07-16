<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            Log::error('RoleMiddleware: Utilisateur non authentifié');
            return response()->json(['message' => 'Non authentifié.'], 401);
        }

        $userRole = $request->user()->role;
        Log::info('RoleMiddleware: Rôle de l\'utilisateur: ' . $userRole);
        Log::info('RoleMiddleware: Rôles requis: ' . implode(', ', $roles));

        // Convertir la chaîne de rôles en tableau si nécessaire
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $role));
        }

        if (!in_array($userRole, $allowedRoles)) {
            Log::warning('RoleMiddleware: Accès refusé pour le rôle ' . $userRole);
            return response()->json([
                'message' => 'Accès non autorisé. Rôle requis : ' . implode(' ou ', $allowedRoles)
            ], 403);
        }

        Log::info('RoleMiddleware: Accès autorisé pour le rôle ' . $userRole);
        return $next($request);
    }
} 