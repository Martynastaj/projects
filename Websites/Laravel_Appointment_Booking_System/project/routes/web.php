<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;

// Strony dla różnych ról - dostępne tylko dla użytkowników niezablokowanych
Route::middleware(['auth', 'check.blocked'])->group(function () {
    Route::get('/client-dashboard', function () {
        return view('client.dashboard');  // Dashboard klienta
    })->name('client.dashboard');

    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');  // Dashboard administratora
    })->name('admin.dashboard');

    Route::get('/dashboard', function () {
        return view('dashboard');  // Dashboard ogólny
    })->name('dashboard');

    Route::get('statistics', [AdminController::class, 'statistics'])->name('admin.stat');
    Route::get('providers-list', [AdminController::class, 'listProviders'])->name('admin.providers');
    Route::get('clients-list', [AdminController::class, 'listClients'])->name('admin.clients');

    Route::get('stat`', [AdminController::class, 'stat1'])->name('admin.stat1');
    Route::get('stat2', [AdminController::class, 'stat2'])->name('admin.stat2');
    Route::get('stat3', [AdminController::class, 'stat3'])->name('admin.stat3');

    Route::post('/admin/providers/{id}/block', [AdminController::class, 'blockProvider'])->name('admin.providers.block');
    Route::post('/admin/providers/{id}/active', [AdminController::class, 'activeProvider'])->name('admin.providers.active');
    Route::delete('/admin/providers/{id}/delete', [AdminController::class, 'deleteProvider'])->name('admin.providers.delete');

    Route::post('/admin/clients/{id}/block', [AdminController::class, 'blockClient'])->name('admin.clients.block');
    Route::post('/admin/clients/{id}/active', [AdminController::class, 'activeClient'])->name('admin.clients.active');
    Route::delete('/admin/clients/{id}/delete', [AdminController::class, 'deleteClient'])->name('admin.clients.delete');

    Route::resource('books', BookController::class);

    Route::get('/admin/clients', [AdminController::class, 'searchFilter'])->name('admin.clients.searchFilter');
    Route::get('/admin/providers', [AdminController::class, 'searchFilterP'])->name('admin.providers.searchFilterP');
});

Route::middleware(['auth', 'check.blocked', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Trasy administracyjne tylko dla niezablokowanych administratorów
    Route::get('/unverified-providers', [AdminController::class, 'unverifiedProviders'])->name('unverified-providers');
    Route::post('/verify-provider/{id}', [AdminController::class, 'verifyProvider'])->name('verify-provider');
});
// Trasa logowania
Route::middleware('guest')->get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/provider-dashboard', [ProviderController::class, 'dashboard'])->name('provider.dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Books
    Route::resource('books', BookController::class);
});

// Trasa logowania
Route::middleware('guest')->post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

// Wylogowanie
Route::middleware('auth')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Wymaganie, aby użytkownik nie był zablokowany
Route::middleware(['auth', 'check.blocked'])->group(function () {
    Route::resource('/comments', CommentController::class);
});

// Strona informująca o zablokowanym koncie i dashboard providera
Route::middleware(['auth'])->group(function () {
    Route::get('/provider-dashboard', function () {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Brak dostępu');
        }

        // Sprawdzenie statusu blokady użytkownika
        if ($user->status === 'blocked') {
            return view('admin.client.blocked');
        }

        // Sprawdzenie walidacji użytkownika
        if (!$user->is_validated) {
            return redirect()->route('admin.unverified-providers');
        }

        // Użytkownik jest zalogowany, zwalidowany i nie zablokowany
        return view('provider.dashboard');
    })->name('provider.dashboard');
    // Wspólne trasy dla zalogowanych użytkowników

    Route::middleware(['auth'])->group(function () {
        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Books
        Route::resource('books', BookController::class);
    });

    // Zarządzanie usługami providera
    Route::get('/provider/services', [ProviderController::class, 'index'])->name('provider.services');
    Route::match(['get', 'post'], '/provider/add-service', [ProviderController::class, 'addService'])->name('provider.add_service');
    Route::match(['get', 'post'], '/provider/edit-service/{service}', [ProviderController::class, 'editService'])->name('provider.edit_service');
    Route::post('/provider/delete-service/{service}', [ProviderController::class, 'deleteService'])->name('provider.delete_service');
    Route::get('/client-dashboard', function () {
        $user = auth()->user();

        if ($user && $user->status === 'blocked') {
            // Jeśli użytkownik jest zablokowany, pokaż stronę z informacją
            return view('admin.client.blocked');
        }

        // Jeśli użytkownik nie jest zablokowany, przejdź do dashboardu
        return app(ClientController::class)->dashboard();
    })->name('client.dashboard');

});
// Strona informująca o zablokowanym koncie
Route::middleware('auth')->get('/admin/client-blocked', function () {
    return view('admin.client.blocked');  // Widok informujący o zablokowanym koncie
})->name('admin.client.blocked');


// Ograniczony dostęp dla usługodawców bez weryfikacji
Route::get('/provider/limited-access', function () {
    return view('provider.limited-access');
})->name('provider.limited-access');
Route::get('/company-info/{provider}', [AdminController::class, 'show'])->name('company.show');
Route::get('/services/{provider}', [AdminController::class, 'showServices'])->name('admin.showServices');
Route::post('/admin/delete-service/{service}', [AdminController::class, 'deleteService'])->name('admin.delete_service');

// Trasy dla klienta

//services
Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');


// Kalendarz wizyt (klient)
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/calendar', [ClientController::class, 'calendar'])->name('client.calendar');
    Route::get('/client/booking/{providerId}', [ClientController::class, 'bookingForm'])->name('client.booking');
    Route::post('/client/booking', [ClientController::class, 'submitBooking'])->name('client.booking.submit');
    Route::delete('/appointments/{id}', [ClientController::class, 'deleteAppointment'])->name('appointments.delete');

});


// Kalendarz dostępności (usługodawca)
Route::middleware(['auth', 'role:provider'])->group(function () {
    Route::get('/provider/calendar', [ProviderController::class, 'calendar'])->name('provider.calendar');
    Route::post('/provider/calendar/save', [ProviderController::class, 'saveAvailability'])->name('provider.calendar.save');
    Route::get('/provider/calendar/events', [ProviderController::class, 'getEvents'])->name('provider.calendar.events');
});
Route::delete('/rezerwacje/{id}', [ClientController::class, 'deleteAppointment'])->name('rezerwacje.delete');


// Lista usług
Route::get('/services', [ServicesController::class, 'index'])->name('services.index');



Route::get('/provider/company-info', [ProviderController::class, 'showCompanyInfo'])
    ->name('provider.company.info');

Route::get('/provider/company-info/edit', [ProviderController::class, 'editCompanyInfo'])
    ->name('provider.edit.company');

Route::put('/provider/company-info/update', [ProviderController::class, 'updateCompanyInfo'])
    ->name('provider.update.company');

Route::get('/provider/calendar/events', [ProviderController::class, 'getEvents'])->name('provider.calendar.events');


require __DIR__ . '/auth.php';
