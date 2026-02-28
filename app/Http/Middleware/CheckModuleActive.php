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

        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized.'
            ], 401);
        }

        $moduleExists = \App\Models\Module::where('name', $module)
            ->where('active', true)
            ->exists();

        if (!$moduleExists) {
            return response()->json([
                'error' => "Module not found or inactive."
            ], 404);
        }

        $hasAccess = $user->modules()
            ->where('modules.name', $module)
            ->exists();

        if (!$hasAccess) {
            return response()->json([
                'error' => "You don't have access to this module."
            ], 403);
        }

        return $next($request);
    }


}