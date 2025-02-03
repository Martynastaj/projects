<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Check if the user is authenticated
        if (Auth::guard($guard)->check()) {
            // Redirect the user to the dashboard if they are authenticated
            return redirect('/dashboard');
        }

        // Continue processing the request if the user is not authenticated
        return $next($request);
    }
}
