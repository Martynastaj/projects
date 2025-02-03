@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-3xl font-bold mb-6 text-center">Rezerwacja wizyty</h1>

        <!-- Wyświetlenie komunikatów sukcesu i błędów -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Sukces!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Błąd!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formularz -->
        <form action="{{ route('client.booking.submit') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            @csrf

            <input type="hidden" name="provider_id" value="{{ $provider->id }}">

            <!-- Wybór daty -->
            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-semibold mb-2">Wybierz datę:</label>
                <input
                    type="date"
                    id="date"
                    name="date"
                    value="{{ old('date', $defaultDate ?? now()->format('Y-m-d')) }}"
                    class="w-full border rounded-lg p-2"
                    required
                >
            </div>

            <!-- Wybór godziny -->
            <div class="mb-4">
                <label for="time" class="block text-gray-700 font-semibold mb-2">Wybierz godzinę:</label>
                <select
                    id="time"
                    name="time"
                    class="w-full border rounded-lg p-2"
                    required
                >
                    <option value="" disabled selected>Wybierz godzinę</option>
                    @foreach ($availabilities as $availability)
                        <option value="{{ $availability->time }}">{{ $availability->time }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Wybór usługi -->
            <div class="mb-4">
                <label for="service_id" class="block text-gray-700 font-semibold mb-2">Wybierz usługę:</label>
                <select
                    id="service_id"
                    name="service_id"
                    class="w-full border rounded-lg p-2"
                    required
                >
                    <option value="" disabled selected>Wybierz usługę</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->duration }} minut)</option>
                    @endforeach
                </select>
            </div>

            <!-- Przycisk Zarezerwuj -->
            <div class="text-center">
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600"
                >
                    Zarezerwuj wizytę
                </button>
            </div>
        </form>
    </div>
@endsection
