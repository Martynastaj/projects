<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Service;
use App\Models\Availability;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Rezerwacja;

class ProviderController extends Controller
{
    public function index(): View
    {
        $services = Service::where('providerID', auth()->id())->get();
        return view('provider.index', compact('services'));
    }

    public function dashboard(): View
    {
        $services = Service::where('providerID', auth()->id())->get();
        return view('provider.dashboard', compact('services'));
    }

    public function addService(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('post')) {
            /** @var array{name: string, duration: int, price: float} $validated */
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'duration' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
            ]);

            Service::create([
                'providerID' => auth()->id(),
                'name' => $validated['name'],
                'duration' => $validated['duration'],
                'price' => $validated['price'],
            ]);
            return redirect()->route('provider.dashboard')->with('success', 'Service added successfully');
        }
        return view('provider.add_service');
    }

    public function editService(Request $request, Service $service): View|RedirectResponse
    {
        //$this->authorize('update', $service

        if ($request->isMethod('post')) {
            /** @var array{name: string, duration: int, price: float} $validated */
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'duration' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
            ]);

            $service->update([
                'name' => $validated['name'],
                'duration' => $validated['duration'],
                'price' => $validated['price'],
            ]);
            return redirect()->route('provider.dashboard')->with('success', 'Service updated successfully');
        }
        return view('provider.edit_service', compact('service'));
    }

    public function deleteService(Service $service): RedirectResponse
    {
        //$this->authorize('delete', $service);
        $service->delete();
        return redirect()->route('provider.dashboard')->with('success', 'Service deleted successfully');
    }

    public function calendar()
    {
        $availabilities = Availability::where('provider_id', auth()->id())->get();
        return view('provider.calendar', compact('availabilities'));
    }

    //to zapis dostepnosci w kalendarzu
    public function saveAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'times' => 'required|array',
        ]);

        // Usuń istniejące godziny dla danego dnia (opcjonalnie)
        Availability::where('provider_id', auth()->id())
            ->where('date', $validatedData['date'])
            ->delete();

        // Zapisz nowe godziny dostępności
        foreach ($validatedData['times'] as $time) {
            Availability::create([
                'provider_id' => auth()->id(),
                'date' => $validatedData['date'],
                'time' => $time,
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    public function showCompanyInfo()
    {
        // Pobierz informacje o firmie powiązane z aktualnym użytkownikiem
        $company = Company::where('user_id', auth()->id())->first();

        return view('provider.company_info', compact('company'));
    }

    public function editCompanyInfo(): View
    {
        // Możesz przekazać aktualne dane do widoku, jeśli są zapisane w bazie danych
        $companyInfo = [
            'description' => 'Jesteśmy liderem w branży kosmetycznej...',
            'address' => 'ul. Piękna 12, 00-001 Warszawa',
            'phone' => '+48 123 456 789',
            'email' => 'kontakt@bookrak.pl',
        ];

        return view('provider.edit_company_info', compact('companyInfo'));
    }

    public function updateCompanyInfo(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        // Zaktualizuj dane w tabeli `companies`
        Company::updateOrCreate(
            ['user_id' => auth()->id()], // Znajdź istniejącą firmę na podstawie `user_id`
            $validated                    // Zaktualizuj dane lub dodaj nowe
        );

        return redirect()->route('provider.company.info')->with('success', 'Informacje o firmie zostały zaktualizowane.');
    }

    public function getEvents()
    {
        $appointments = Rezerwacja::where('provider_id', auth()->id())
            ->whereDate('date', '>=', now()->format('Y-m-d'))
            ->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->service->name,
                'start' => $appointment->date . 'T' . $appointment->time,
                'extendedProps' => [
                    'client_name' => $appointment->client->name,
                    'client_email' => $appointment->client->email,
                    'service_name' => $appointment->service->name,
                    'date' => $appointment->date,
                    'time' => $appointment->time,
                ],
            ];
        });

        // Dodaj logowanie
        \Log::info('Wizyty do kalendarza:', $events->toArray());

        return response()->json($events);
    }



}
