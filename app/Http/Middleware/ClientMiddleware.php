<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and user_type = admin
        if (auth()->check() && auth()->user()->user_type === 'client') {
            return $next($request);
        }

        // Otherwise redirect to home or show 403
        abort(403, 'Unauthorized access.');
    }
}
