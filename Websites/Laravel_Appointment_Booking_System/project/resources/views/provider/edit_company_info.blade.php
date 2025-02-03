@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edytuj Informacje o Firmie') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('provider.update.company') }}" class="bg-white shadow-lg rounded-lg p-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Opis firmy:</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300"
                              required>{{ old('description', $company->description ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700">Adres:</label>
                    <input id="address" name="address" type="text"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300"
                           value="{{ old('address', $company->address ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700">Telefon:</label>
                    <input id="phone" name="phone" type="text"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300"
                           value="{{ old('phone', $company->phone ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email:</label>
                    <input id="email" name="email" type="email"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300"
                           value="{{ old('email', $company->email ?? '') }}" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-all">
                        Zapisz zmiany
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
