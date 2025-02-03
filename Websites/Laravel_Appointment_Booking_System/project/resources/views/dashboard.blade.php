@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('') }}
    </h2>
@endsection

@section('content')
    <main class="mt-6">
        <!-- Sekcja wyszukiwarki -->
        <div class="h-60 bg-gray-100 mt-3 flex justify-center items-center w-full">
            <form method="GET" action="{{ route('services.index') }}" class="flex space-x-4 items-center w-1/3">
                <input type="text" name="search" placeholder="Szukaj usługi lub salonu..."
                       class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit"
                        class="p-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-150">
                    Szukaj
                </button>
            </form>
        </div>


        <!-- Kafelki kategorii (wyświetlane w poziomie) QA-->
        <div class="mt-6 flex justify-center space-x-4">
            <div class="bg-blue-300 hover:bg-blue-300 transition duration-150 rounded-lg p-6 text-center w-48">
                <a href="{{ route('services.index', ['category' => 'Fryzjer']) }}" class="text-gray-800 font-semibold">Fryzjer</a>
            </div>
            <div class="bg-blue-300 hover:bg-blue-300 transition duration-150 rounded-lg p-6 text-center w-48">
                <a href="{{ route('services.index', ['category' => 'Paznokcie']) }}" class="text-gray-800 font-semibold">Paznokcie</a>
            </div>
            <div class="bg-blue-300 hover:bg-blue-300 transition duration-150 rounded-lg p-6 text-center w-48">
                <a href="{{ route('services.index', ['category' => 'Masaż']) }}" class="text-gray-800 font-semibold">Masaż</a>
            </div>
            <div class="bg-blue-300 hover:bg-blue-300 transition duration-150 rounded-lg p-6 text-center w-48">
                <a href="{{ route('services.index', ['category' => 'Depilacja']) }}" class="text-gray-800 font-semibold">Depilacja</a>
            </div>
            <div class="bg-blue-300 hover:bg-blue-300 transition duration-150 rounded-lg p-6 text-center w-48">
                <a href="{{ route('services.index', ['category' => 'Brwi/Rzęsy']) }}" class="text-gray-800 font-semibold">Brwi/Rzęsy</a>
            </div>
        </div>

        <!-- Sekcja informacji -->
        <div class="grid gap-6 mt-6">
            <!-- Kontener "O nas" -->
            <div class="bg-white shadow-md rounded-md p-4 text-center w-2/3 mx-auto">
                <h3 class="text-base font-semibold text-gray-800">O nas</h3>
                <p class="mt-2 text-sm text-gray-600">
                    Jest to serwis: system rezerwacji wizyt inspirowany na Booksy - BooKrak. Klienci mogą umawiać się na różne usługi, takie jak makijaż, masaż, paznokcie i wiele innych. Jeśli jesteś usługodawcą, możesz założyć konto. Admin musi Cię zweryfikować przed rozpoczęciem działalności.
                </p>
            </div>

            <!-- Kontener "Jak korzystać" -->
            <div class="bg-white shadow-md rounded-md p-4 text-center w-2/3 mx-auto">
                <h3 class="text-base font-semibold text-gray-800">Jak korzystać ze strony</h3>
                <p class="mt-2 text-sm text-gray-600">
                    Nasza strona jest zaprojektowana z myślą o łatwości użytkowania. Możesz wyszukiwać usługi według kategorii, korzystać z filtrów, aby szybko znaleźć to, czego potrzebujesz. Sprawdź instrukcję, aby w pełni wykorzystać wszystkie funkcje!
                </p>
            </div>

            <!-- Kontener "Profil zablokowany" -->
            <div class="bg-white shadow-md rounded-md p-4 text-center w-2/3 mx-auto">
                <h3 class="text-base font-semibold text-gray-800">Co gdy mój profil zostanie zablokowany?</h3>
                <p class="mt-2 text-sm text-gray-600">
                    Jeśli twój profil zostanie zablokowany, skontaktuj się z naszym zespołem wsparcia. Pomożemy Ci przywrócić dostęp lub rozwiązać problem. Przeczytaj nasz regulamin, aby unikać blokad w przyszłości.
                </p>
            </div>
        </div>




        <!-- Stopka -->
        <footer class="py-6 text-center text-sm text-gray-600 bg-gray-100 mt-8">
            BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
        </footer>
    </main>

@endsection
