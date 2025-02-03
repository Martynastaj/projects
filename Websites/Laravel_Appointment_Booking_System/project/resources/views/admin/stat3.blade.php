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
                        {{ __("CENY I CZAS TRWANIA USŁUG") }}
                    </div>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 px-4">
                    <!-- Najniższa cena usługi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Najniższa cena usługi</h3>
                        <p class="mt-2 text-xl">{{ $lowestServicePrice }} zł</p>
                    </div>

                    <!-- Najwyższa cena usługi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Najwyższa cena usługi</h3>
                        <p class="mt-2 text-xl">{{ $highiesServicePrice }} zł</p>
                    </div>

                    <!-- Średnia cena usługi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Średnia cena usługi</h3>
                        <p class="mt-2 text-xl">{{ $averageServicePrice }} zł</p>
                    </div>

                    <!-- Najkrótszy czas trwania usługi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Najkrótszy czas trwania usługi</h3>
                        <p class="mt-2 text-xl">{{ $minDuration }} minut</p>
                    </div>

                    <!-- Najdłuższy czas trwania usługi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Najdłuższy czas trwania usługi</h3>
                        <p class="mt-2 text-xl">{{ $maxDuration }} minut</p>
                    </div>

                    <!-- Średni czas trwania usługi -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg">Średni czas trwania usługi</h3>
                        <p class="mt-2 text-xl">{{ $meanDuration }} minuty</p>
                    </div>
                </div>
            </div>

        </div>

        <footer class="py-4 text-center text-sm text-gray-600 bg-gray-100 mt-8">
            BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
        </footer>
@endsection
