<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        if (! $request->user()->tokenCan($user->role)) {
            return response()->json(['message' => 'Invalid token for this role'], 402);
        }

        return $next($request);
    }
}