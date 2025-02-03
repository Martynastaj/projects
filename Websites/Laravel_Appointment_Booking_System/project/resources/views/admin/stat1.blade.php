@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin dashboard') }}
    </h2>
@endsection

@section('content')


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mt-6 text-xl font-semibold overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        {{ __("STATYSTYKI UŻYTKOWNIKÓW") }}
                    </div>
                </div>

                <!-- Statystyki -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 px-4">
                    <!-- Liczba użytkowników -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Liczba użytkowników</h3>
                        <p class="mt-2 text-xl">{{ $totalUsers }}</p>
                    </div>

                    <!-- Liczba usługodawców -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Liczba usługodawców</h3>
                        <p class="mt-2 text-xl">{{ $providersCount }}</p>
                    </div>

                    <!-- Liczba klientów -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Liczba klientów</h3>
                        <p class="mt-2 text-xl">{{ $clientsCount }}</p>
                    </div>

                    <!-- Liczba aktywnych kont -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Liczba aktywnych kont</h3>
                        <p class="mt-2 text-xl">{{ $activeUsers }}</p>
                    </div>

                    <!-- Liczba zawieszonych kont -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Liczba zawieszonych kont</h3>
                        <p class="mt-2 text-xl">{{ $blockedUsers }}</p>
                    </div>

                    <!-- Liczba uzytkownikow do zweryfikowania -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Niezweryfikowane konta</h3>
                        <p class="mt-2 text-xl">{{ $unverifiedUsers }}</p>
                    </div>
                </div>

            </div>

        </div>

    <footer class="py-4 text-center text-sm text-gray-600 bg-gray-100 mt-8">
        BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
    </footer>
@endsection
