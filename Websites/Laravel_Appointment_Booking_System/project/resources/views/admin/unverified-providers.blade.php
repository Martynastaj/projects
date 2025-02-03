@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Nowe walidacje') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white shadow-sm rounded-lg p-6 mt-6">
        <div class="p-4 text-gray-900 mb-4">
            <h3 class="text-xl font-semibold">{{ __("NOWE WERYFIKACJE") }}</h3>
        </div>

        @if ($providers->isEmpty()) <!-- Sprawdzamy, czy kolekcja jest pusta -->
        <p class="text-gray-600">Brak nowych weryfikacji</p> <!-- Wyświetlamy komunikat -->
        @else
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                <tr>
                    <th class="py-2 px-4 border-b">#</th>
                    <th class="py-2 px-4 border-b">Imię</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Akcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($providers as $index => $provider)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $provider->name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $provider->email }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="flex space-x-2 justify-center">
                                <form action="{{ route('admin.verify-provider', $provider->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded-md hover:bg-green-600">
                                        Weryfikuj użytkownika
                                    </button>
                                </form>

                                <form action="{{ route('company.show', $provider->id) }}" method="GET" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded-md hover:bg-yellow-600 transition-all">
                                        Wyświetl informacje
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        @endif

    </div>
    <footer class="py-4 text-center text-sm text-gray-600 bg-gray-100 mt-8">
        BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
    </footer>
@endsection
