@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Client Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Pionowy układ kafelków -->
            <div class="space-y-6">
                <!-- Kafelek "Twoje Wizyty" -->
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Twoje wizyty</h3>
                    <p class="text-gray-600 text-sm text-center">
                        Masz {{ $appointmentsCount ?? 0 }} zaplanowanych wizyt.
                    </p>
                    <a href="{{ route('client.calendar') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mt-4">
                        Przeglądaj
                    </a>
                </div>

                <!-- Kafelek "Przeglądaj Oferty" -->
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Przeglądaj Oferty</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Znajdź usługę, która Cię interesuje.
                    </p>
                    <a href="{{ route('services.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all">
                        Przeglądaj oferty
                    </a>
                </div>

                <!-- Minione wizyty -->
                <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 text-center">Minione wizyty</h3>
                    @if ($pastAppointments->isEmpty())
                        <p class="text-gray-600 mt-2 text-center">Nie masz jeszcze żadnych minionych wizyt.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            @foreach ($pastAppointments as $appointment)
                                <div class="bg-gray-100 shadow-md rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-gray-800 text-center">{{ $appointment->service->name }}</h4>
                                    <p class="text-gray-600 text-sm text-center">Data: {{ $appointment->date }}</p>
                                    <div class="flex justify-center mt-3">
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 text-sm"
                                                data-title="{{ $appointment->service->name }}"
                                                data-date="{{ $appointment->date }}"
                                                data-time="{{ $appointment->time }}"
                                                data-provider="{{ $appointment->provider->name ?? 'Nieznany usługodawca' }}"
                                                onclick="showAppointmentDetails(this)">
                                            Zobacz szczegóły
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Modal dla szczegółów wizyty -->
    <div id="appointment-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h3 id="modal-title" class="text-xl font-bold mb-4 text-gray-800"></h3>
            <p id="modal-date" class="text-gray-600 mb-2"></p>
            <p id="modal-time" class="text-gray-600 mb-2"></p>
            <p id="modal-provider" class="text-gray-600 mb-4"></p>
            <div class="flex justify-between">
                <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">
                    Zamknij
                </button>
            </div>
        </div>
    </div>

    <script>
        function showAppointmentDetails(button) {
            document.getElementById('modal-title').textContent = `Usługa: ${button.dataset.title}`;
            document.getElementById('modal-date').textContent = `Data: ${button.dataset.date}`;
            document.getElementById('modal-time').textContent = `Godzina: ${button.dataset.time}`;
            document.getElementById('modal-provider').textContent = `Usługodawca: ${button.dataset.provider}`;

            document.getElementById('appointment-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('appointment-modal').classList.add('hidden');
        }
    </script>
@endsection
