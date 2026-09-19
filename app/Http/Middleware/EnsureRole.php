<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Restrict a request to users whose role matches one of the given roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()?->hasRole($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
