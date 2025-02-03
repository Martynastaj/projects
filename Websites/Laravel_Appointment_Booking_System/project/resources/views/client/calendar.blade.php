@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Kalendarz Klienta') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Sekcja Kalendarza -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4 text-center">Kalendarz Twoich Wizyt</h1>

                <!-- Kalendarz -->
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="event-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h3 id="modal-title" class="text-xl font-bold mb-4 text-gray-800"></h3>
            <p id="modal-date" class="text-gray-600 mb-2"></p>
            <p id="modal-time" class="text-gray-600 mb-4"></p>
            <div class="flex justify-between">
                <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Zamknij
                </button>
                <button id="cancel-appointment-btn" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Anuluj wizytę
                </button>
            </div>
        </div>
    </div>

    <!-- Skrypt inicjalizujący FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pl',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {!! json_encode($events) !!}, // Wydarzenia przekazane z backendu
                eventClick: function (info) {
                    const event = info.event;

                    // Wyświetlenie szczegółów w modalu
                    document.getElementById('modal-title').textContent = `Usługa: ${event.title}`;
                    document.getElementById('modal-date').textContent = `Data: ${event.start.toISOString().slice(0, 10)}`;
                    const localTime = new Date(event.start).toLocaleTimeString('pl-PL', { hour: '2-digit', minute: '2-digit' });
                    document.getElementById('modal-time').textContent = `Godzina: ${localTime}`;


                    // Sprawdź, czy event.extendedProps.id istnieje
                    if (event.extendedProps.id) {
                        const cancelButton = document.getElementById('cancel-appointment-btn');
                        cancelButton.dataset.appointmentId = event.extendedProps.id; // Przypisanie poprawnego ID
                    } else {
                        console.error("ID wizyty nie zostało przekazane!");
                    }

                    document.getElementById('event-modal').classList.remove('hidden');
                },

            });

            calendar.render();
        });

        function closeModal() {
            document.getElementById('event-modal').classList.add('hidden');
        }

        // Obsługa przycisku "Anuluj wizytę"
        document.getElementById('cancel-appointment-btn').addEventListener('click', function () {
            const appointmentId = this.dataset.appointmentId;

            if (confirm('Czy na pewno chcesz anulować tę wizytę?')) {
                fetch(`/rezerwacje/${appointmentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            alert('Wizyta została anulowana.');
                            location.reload(); // Odśwież stronę
                        } else {
                            alert('Wystąpił błąd podczas anulowania wizyty.');
                        }
                    })
                    .catch(error => {
                        console.error('Błąd:', error);
                        alert('Wystąpił problem podczas anulowania wizyty.');
                    });
            }
        });
    </script>
@endsection
