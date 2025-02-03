@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Provider Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Pionowy układ kafelków -->
            <div class="space-y-6">
                <!-- Kafelek "Twoje Usługi" -->
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Twoje Usługi</h3>
{{--                    <p class="mt-2 text-sm text-gray-600">Masz {{ $services->count() }} dodanych usług.</p>--}}
                    <a href="{{ route('provider.services') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all">
                        Zobacz swoje usługi
                    </a>
                </div>

                <!-- Kafelek "Kalendarz" -->
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Kalendarz</h3>
                    <p class="mt-2 text-sm text-gray-600">Zarządzaj swoim harmonogramem wizyt.</p>
                    <a href="{{ route('provider.calendar') }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all">
                        Zarządzaj kalendarzem
                    </a>
                </div>

                <!-- Kafelek "Informacje o Firmie" -->
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800">Informacje o Firmie</h3>
                    <p class="mt-2 text-sm text-gray-600">Zarządzaj informacjami o swojej firmie.</p>
                    <a href="{{ route('provider.company.info') }}" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all">
                        Edytuj informacje
                    </a>
                </div>
            </div>
        </div>
    </div>
    <footer class="py-4 text-center text-sm text-gray-600 bg-gray-100 mt-8">
        BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
    </footer>
@endsection
