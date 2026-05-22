<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Deny access if the authenticated user is not an admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // User must be logged in AND have the admin role
        if (!$request->user() || !$request->user()->isAdmin()) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
