<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kalendarz Usługodawcy</h2>
@endsection
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal -->
    <div id="event-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h3 id="modal-title" class="text-xl font-bold mb-4 text-gray-800"></h3>
            <p id="modal-client-name" class="text-gray-600 mb-2"></p>
            <p id="modal-client-email" class="text-gray-600 mb-2"></p>
            <p id="modal-date" class="text-gray-600 mb-2"></p>
            <p id="modal-time" class="text-gray-600 mb-4"></p>
            <div class="flex justify-center">
                <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Zamknij
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pl',
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                dateClick: function (info) {
                    const selectedDate = info.dateStr;
                    const hours = prompt(`Podaj godziny dostępności dla dnia ${selectedDate} (np. 10:00,11:00,14:30):`);
                    if (hours) {
                        const times = hours.split(',').map(time => time.trim());
                        fetch('{{ route('provider.calendar.save') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                date: selectedDate,
                                times: times
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert('Godziny dostępności zostały zapisane!');
                                    calendar.refetchEvents(); // Odświeżenie wydarzeń w kalendarzu
                                } else {
                                    alert('Wystąpił problem podczas zapisu godzin.');
                                }
                            })
                            .catch(error => {
                                console.error('Błąd:', error);
                                alert('Wystąpił błąd podczas komunikacji z serwerem.');
                            });
                    }
                },
                events: '{{ route('provider.calendar.events') }}',
                eventClick: function (info) {
                    const event = info.event;

                    // Wyświetlanie szczegółów wizyty w modalu
                    document.getElementById('modal-title').textContent = `Usługa: ${event.extendedProps.service_name}`;
                    document.getElementById('modal-client-name').textContent = `Klient: ${event.extendedProps.client_name}`;
                    document.getElementById('modal-client-email').textContent = `Email: ${event.extendedProps.client_email}`;
                    document.getElementById('modal-date').textContent = `Data: ${event.extendedProps.date}`;
                    document.getElementById('modal-time').textContent = `Godzina: ${event.extendedProps.time}`;

                    document.getElementById('event-modal').classList.remove('hidden');
                }
            });

            calendar.render();
        });

        function closeModal() {
            document.getElementById('event-modal').classList.add('hidden');
        }
    </script>
@endsection
