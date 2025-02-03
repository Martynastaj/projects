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
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informacje o Firmie</h3>

                <!-- Informacje o firmie -->
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-700">Opis firmy:</h4>
                    <p class="text-sm text-gray-600 mt-2">
                        {{ $company->description ?? 'Brak opisu firmy.' }}
                    </p>
                </div>

                <!-- Dane kontaktowe -->
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-700">Dane kontaktowe:</h4>
                    <ul class="text-sm text-gray-600 mt-2">
                        <li><strong>Adres:</strong> {{ $company->address ?? 'Brak adresu' }}</li>
                        <li><strong>Telefon:</strong> {{ $company->phone ?? 'Brak telefonu' }}</li>
                        <li><strong>Email:</strong> {{ $company->email ?? 'Brak emaila' }}</li>
                    </ul>
                </div>

                <!-- Przycisk Edytuj -->
                <div class="text-center">
                    <a href="{{ route('provider.edit.company') }}"
                       class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-all">
                        Edytuj
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
