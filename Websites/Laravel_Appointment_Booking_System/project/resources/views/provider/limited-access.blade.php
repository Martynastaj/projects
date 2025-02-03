<!-- resources/views/admin/client/blocked.blade.php -->

@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ograniczony dostęp') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-red-600 ">
                        {{ __("Twoje konto musi zostać zweryfikowane przez administratora.") }}
                    </h3>
                    <p class="mt-4">
                        Skontaktuj się z administratorem lub dodaj opis swojej firmy, aby przyspieszyć proces weryfikacji.
                    </p>

                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 mt-8 text-center">
                <h3 class="text-lg font-semibold text-gray-800">Informacje o Firmie</h3>
                <p class="mt-2 text-sm text-gray-600">Dodaj informacje o swojej firmie, aby przysipeszyć proces weryfikacji.</p>
                <a href="{{ route('provider.company.info') }}" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all">
                    Edytuj informacje
                </a>
            </div>
        </div>
    </div>
@endsection
