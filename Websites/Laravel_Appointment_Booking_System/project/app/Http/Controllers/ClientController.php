<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Rezerwacja;
use App\Models\Availability;
use App\Models\User;

class ClientController extends Controller
{
    /**
     * Wyświetla dashboard klienta z opiniami i przyciskiem do kalendarza.
     */
    public function dashboard(): View
    {
        // Pobierz liczbę przyszłych wizyt
        $appointmentsCount = Rezerwacja::where('client_id', auth()->id())
            ->whereDate('date', '>=', now()->format('Y-m-d'))
            ->count();

        // Pobierz przeszłe wizyty
        $pastAppointments = Rezerwacja::where('client_id', auth()->id())
            ->whereDate('date', '<', now()->format('Y-m-d'))
            ->orderBy('date', 'desc')
            ->get();

        return view('client.dashboard', compact('appointmentsCount', 'pastAppointments'));
    }

    public function deleteAppointment($id)
    {
        $appointment = Rezerwacja::where('id', $id)
            ->where('client_id', auth()->id())
            ->first();

        if (!$appointment) {
            return response()->json(['error' => 'Nie znaleziono wizyty'], 404);
        }

        $appointment->delete();

        return response()->json(['success' => 'Wizyta została anulowana'], 200);
    }





    /**
     * Wyświetla listę dostępnych usług.
     */
    public function services(): View
    {
        $services = Service::all();
        return view('client.services', compact('services'));
    }

    public function calendar(): View
    {
        $appointments = Rezerwacja::where('client_id', auth()->id())->get();

        // Mapowanie wydarzeń na format FullCalendar
        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id, // dodanie ID rezerwacji
                'title' => $appointment->service->name,
                'start' => $appointment->date . 'T' . $appointment->time,
                'color' => '#3788d8', //kolor
                'extendedProps' => [
                    'id' => $appointment->id, // Przekazanie ID do extendedProps
                ],
            ];
        });

        return view('client.calendar', compact('events'));
    }


    public function bookingForm($providerId)
    {
        $date = request('date' ?: now()->format('Y-m-d'));
        //$date = request('date' ?: now()->format('Y-m-d')); // Ustaw dzisiejszą datę jako domyślną, jeśli brak daty w żądaniu
        $provider = User::findOrFail($providerId);
        //dd(request()->all());
        //dd(request('date'), $date);

        // Pobierz wszystkie dostępne godziny od usługodawcy
        $allAvailabilities = Availability::where('provider_id', $providerId)
            ->when($date, function ($query) use ($date) {
                $query->where('date', $date);
            })
            ->get();

        //dd($availabilities, $date, $providerId);

        // Pobierz zarezerwowane godziny w danym dniu
        $bookedHours = Rezerwacja::where('date', $date)
            ->where('service_id', $providerId)
            ->pluck('time')
            ->toArray();

        //dd($availabilities, $date, $providerId);

        //Log::info('Przed reject', $availabilities->toArray());

        // Usuń z dostępnych godzin godziny już zarezerwowane
        $availabilities = $allAvailabilities->reject(function ($availability) use ($bookedHours) {
            return in_array($availability->time, $bookedHours);
        });

        //Log::info('Po reject', $availabilities->toArray());

        // Pobierz dostępne usługi od usługodawcy
        $services = Service::where('providerID', $providerId)->get();

        // Przekazanie zmiennych do widoku

        return view('client.booking', compact('availabilities', 'services', 'providerId', 'date', 'provider'));

    }
    public function submitBooking(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'date' => 'required|date|after_or_equal:today', // Sprawdzenie, czy data nie jest wcześniejsza niż dzisiaj
            'time' => 'required',
            'service_id' => 'required|exists:services,id',
        ]);

        // Sprawdź, czy godzina jest już zajęta
        $isBooked = Rezerwacja::where('date', $request->date)
            ->where('time', $request->time)
            ->where('service_id', $request->service_id)
            ->exists();

        if ($isBooked) {
            return redirect()->back()->with('error', 'Wybrana godzina jest już zajęta.');
        }

        // Pobierz usługę, aby ustalić `provider_id`
        $service = Service::findOrFail($request->service_id);

        // Zapisz rezerwację w bazie danych
        Rezerwacja::create([
            'date' => $request->date,
            'time' => $request->time,
            'service_id' => $request->service_id,
            'client_id' => auth()->id(),
            'provider_id' => $service->providerID,
        ]);

        // Przekierowanie z komunikatem o sukcesie
        return redirect()->route('client.calendar')->with('success', 'Wizyta została pomyślnie zarezerwowana.');
    }

}
