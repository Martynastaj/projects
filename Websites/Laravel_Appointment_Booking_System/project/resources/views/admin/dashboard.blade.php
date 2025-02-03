@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <!-- Sekcja z linkami do usługodawców i klientów (obok siebie) -->
            <!-- Kontener "Sprawdź listę usługodawców" -->
            <div class="space-y-6">
                <!-- Kafelek "Sprawdź listę usługodawców" -->
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Sprawdź listę usługodawców</h3>
                    <p class="mt-2 text-sm text-gray-600">Zarządzaj usługodawcami w systemie.</p>
                    <a href="{{ route('admin.providers') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all">
                        Zobacz usługodawców
                    </a>
                </div>

                <!-- Kafelek "Sprawdź listę klientów" -->
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Sprawdź listę klientów</h3>
                    <p class="mt-2 text-sm text-gray-600">Zarządzaj klientami w systemie.</p>
                    <a href="{{ route('admin.clients') }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all">
                        Zobacz klientów
                    </a>
                </div>

                <!-- Kafelek "Nowe walidacje" -->
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __("Nowe walidacje") }}</h3>
                    <p class="mt-2 text-sm text-gray-600">Zobacz i weryfikuj nowych usługodawców.</p>
                    <a href="{{ route('admin.unverified-providers') }}" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-all">
                        Sprawdź weryfikacje
                    </a>
                </div>
            </div>

        </div>

        <footer class="py-4 text-center text-sm text-gray-600 bg-gray-100 mt-8">
            BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
        </footer>
    </div>

@endsection
