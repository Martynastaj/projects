<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  The role the user must have
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Sprawdź, czy użytkownik jest zalogowany i ma odpowiednią rolę
        $user = auth()->user();

        if ($user && $user->role === $role) {
            // Użytkownik ma odpowiednią rolę, kontynuujemy z dalszymi akcjami
            return $next($request);  // Przekazuje zapytanie do następnego middleware
        }

        // Jeśli użytkownik nie ma odpowiedniej roli, zwróć błąd 403
        return abort(403, 'Nie masz uprawnień do dostępu do tej strony.');
    }
}
