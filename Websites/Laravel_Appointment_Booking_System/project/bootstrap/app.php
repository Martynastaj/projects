<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckIfBlocked;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',         // Trasy dla aplikacji webowej
        commands: __DIR__.'/../routes/console.php', // Trasy dla komend Artisan
        health: '/up',                             // Endpoint do sprawdzania stanu aplikacji
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Globalne middleware - dla każdego żądania HTTP
        $middleware->append([
            HandleCors::class,               // Obsługa CORS
            TrimStrings::class,   // Obcinanie spacji
        ]);

        // Middleware grupowe: "web" i "api"
        $middleware->group('web', [
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            SubstituteBindings::class,
        ]);

        $middleware->group('api', [
            ThrottleRequests::class . ':api',          // Ograniczenie liczby żądań
            SubstituteBindings::class,
        ]);

        // Alias dla middleware do tras
        $middleware->alias([
            'auth' => Authenticate::class,       // Autoryzacja
            'guest' => RedirectIfAuthenticated::class, // Goście (niezalogowani)
            'role' => RoleMiddleware::class,     // Middleware dla ról użytkowników
            'verified' => EnsureEmailIsVerified::class, // Weryfikacja emaila
            'check.blocked' => CheckIfBlocked::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Obsługa wyjątków - dostosuj według potrzeb
        $exceptions->reportable(function (Throwable $e) {
            // Logowanie wyjątków
        });
    })->create();
