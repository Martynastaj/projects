<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Jeśli użytkownik nie jest zalogowany, przekieruj na stronę logowania
            return redirect()->route('login');
        }

        // Użytkownik jest zalogowany, przechodzimy do następnego middleware
        return $next($request);
    }
}
