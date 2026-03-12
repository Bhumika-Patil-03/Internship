<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND if they are an admin (1)
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        // If not admin, block access
        abort(403, 'Unauthorized access.');
    }
}