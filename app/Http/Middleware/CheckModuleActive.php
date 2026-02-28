<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


        public function handle(Request $request, Closure $next, string $module)
    {
        $user = $request->user();

        // Vérifie si l'utilisateur est connecté
        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized.'
            ], 401);
        }

        $isActive = $user->modules()
            ->where('name', $module)
            ->where('active', true)
            ->exists();

        if (!$isActive) {
            return response()->json([
                "error" => "Module inactive. Please activate this module to use it."
            ], 403);
        }

        return $next($request);
    }


}