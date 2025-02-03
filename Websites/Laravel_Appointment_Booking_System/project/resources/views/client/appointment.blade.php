@extends('layouts.app')

@section('styles')
    <!-- FullCalendar CSS -->
    <link href="{{ asset('fullcalendar/main.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6 text-center">Kalendarz Wizyt</h1>

            <!-- Kalendarz zaplanowanych wizyt -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div id="calendar"></div>
            </div>

            <!-- Lista poprzednich wizyt -->
            <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Poprzednie Wizyty</h2>
                @if ($pastAppointments->isEmpty())
                    <p class="text-gray-600">Nie masz żadnych zakończonych wizyt.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($pastAppointments as $appointment)
                            <li class="p-4 border border-gray-200 rounded-md shadow-sm">
                                <p><strong>Usługa:</strong> {{ $appointment->service->name }}</p>
                                <p><strong>Data:</strong> {{ $appointment->date->format('d-m-Y H:i') }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- FullCalendar JS -->
    <script src="{{ asset('fullcalendar/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pl', // Polski język kalendarza
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Dzisiaj',
                    month: 'Miesiąc',
                    week: 'Tydzień',
                    day: 'Dzień',
                },
                events: {!! json_encode($upcomingAppointments->map(function ($appointment) {
                    return [
                        'title' => $appointment->service->name,
                        'start' => $appointment->date->toDateTimeString(),
                        'end' => $appointment->date->addMinutes($appointment->service->duration ?? 60)->toDateTimeString(),
                        'color' => '#3788d8', // Opcjonalny kolor wydarzenia
                    ];
                })->toArray()) !!},
                eventClick: function (info) {
                    alert('Kliknięto wydarzenie: ' + info.event.title);
                }
            });

            calendar.render();
        });
    </script>
@endsection
