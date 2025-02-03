<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Sprawdź, czy użytkownik jest zalogowany
        $user = Auth::user();

        // Jeśli użytkownik nie jest zalogowany, kontynuuj bez żadnych zmian
        if ($user) {
            if ($user->status === 'blocked') {
                // Zablokuj dostęp do innych stron, ale pozwól na wylogowanie
                if ($request->is('logout') || $request->is('admin/client-blocked')) {
                    return $next($request);
                }

                // Jeśli użytkownik jest zablokowany, przekieruj go na stronę z komunikatem
                return redirect()->route('admin.client.blocked')
                    ->with('error', 'Twoje konto zostało zablokowane.');
            }

            // Sprawdź, czy użytkownik jest usługodawcą i czy jest zweryfikowany
            if ($user->role === 'provider' && !$user->is_validated) {
                return redirect()->route('provider.limited-access')
                    ->with('error', 'Twoje konto musi zostać zweryfikowane przez administratora.');
            }
        }

        return $next($request);
    }
}
