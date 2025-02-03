@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Informacje o Firmie') }}
    </h2>
@endsection

@section('content')


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-3xl font-semibold text-gray-800 mb-4">Informacje o Firmie</h3>

                <!-- Informacje o firmie -->
                <div class="mb-6">
                    <h4 class="text-xl font-semibold text-gray-700">Opis firmy:</h4>
                    <p class="text-md text-gray-600 mt-2">
                        {{ $company->description ?? 'Brak opisu firmy.' }}
                    </p>
                </div>

                <!-- Dane kontaktowe -->
                <div class="mb-6">
                    <h4 class="text-xl font-semibold text-gray-700">Dane kontaktowe:</h4>
                    <ul class="text-md text-gray-600 mt-2">
                        <li><strong>Adres:</strong> {{ $company->address ?? 'Brak adresu' }}</li>
                        <li><strong>Telefon:</strong> {{ $company->phone ?? 'Brak telefonu' }}</li>
                        <li><strong>Email:</strong> {{ $company->email ?? 'Brak emaila' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
