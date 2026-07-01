<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Usage: ->middleware('role:admin') or 'role:admin,superadmin'.
     * superadmin implicitly passes any admin-gated route.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (! $user->hasRole(...$roles)) {
            abort(403, 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
