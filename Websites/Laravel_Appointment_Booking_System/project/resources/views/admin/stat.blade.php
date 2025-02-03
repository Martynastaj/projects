@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin dashboard') }}
    </h2>
@endsection

@section('content')


    <div class=" py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">


        <div class="space-y-6">
            <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <a href="{{ route('admin.stat1') }}" class=" text-2xl inline-block bg-blue-500 text-white px-6 py-4 rounded-lg hover:bg-blue-600 transition-all">
                    Sprawdź statystyki użytkowników
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <a href="{{ route('admin.stat2') }}" class=" text-2xl inline-block bg-green-500 text-white px-6 py-4  rounded-lg hover:bg-green-600 transition-all">
                    Sprawdź statystyki usług
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <a href="{{ route('admin.stat3') }}" class=" text-2xl inline-block bg-red-500 text-white px-6 py-4  rounded-lg hover:bg-yellow-600 transition-all">
                    Zobacz ceny i czasy trwania usług
                </a>
            </div>
        </div>

    </div>

    <footer class="py-4 text-center text-sm text-gray-600 bg-gray-100 mt-8">
        BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
    </footer>
@endsection
