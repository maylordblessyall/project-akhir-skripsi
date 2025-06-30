<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        $userRole = $user ? $user->access_level : null;

        $roles = array_map('strtolower', $roles);
        if (!$user || !in_array(strtolower($userRole), $roles)) {
            Log::warning('Unauthorized role access', [
                'user_id' => $user ? $user->id : null,
                'user_role' => $userRole,
                'required_roles' => $roles,
                'route' => $request->route()->getName(),
            ]);
            return redirect()->route('dashboard')->with('error', 'You do not have the required role to access this page.');
        }

        Log::info('Role access granted', [
            'user_id' => $user->id,
            'access_level' => $userRole,
            'required_roles' => $roles,
            'route' => $request->route()->getName(),
        ]);

        return $next($request);
    }
}