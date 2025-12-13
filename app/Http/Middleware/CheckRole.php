<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user() || ! $request->user()->active) {
            abort(403, 'Your account is inactive.');
        }

        // If no roles defined in middleware argument, just require active (done above)
        if (empty($roles)) {
            return $next($request);
        }

        // Check against user's role slug
        if (! in_array($request->user()->role->slug, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
