@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Lista usługodawców') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <div class="p-4 text-gray-900 mb-4">
            <h3 class="text-xl font-semibold">{{ __("LISTA USŁUGODAWCÓW") }}</h3>
        </div>

        <!-- Formularz wyszukiwania, filtrowania i sortowania -->
        <form method="GET" action="{{ route('admin.providers.searchFilterP') }}" class="flex flex-wrap space-x-4 mb-6 gap-4">
            <!-- Wyszukiwanie -->
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Imię / Email"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                />
            </div>

            <!-- Filtrowanie statusu -->
            <div class="flex-1">
                <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="">Wszystkie</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktywni</option>
                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Zablokowani</option>
                </select>
            </div>

            <!-- Sortowanie -->
            <div class="flex-1">
                <select name="sortBy" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="name" {{ request('sortBy') == 'name' ? 'selected' : '' }}>Imię</option>
                    <option value="email" {{ request('sortBy') == 'email' ? 'selected' : '' }}>Email</option>
                </select>
            </div>

            <div class="flex-1">
                <select name="sortOrder" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="asc" {{ request('sortOrder') == 'asc' ? 'selected' : '' }}>Rosnąco</option>
                    <option value="desc" {{ request('sortOrder') == 'desc' ? 'selected' : '' }}>Malejąco</option>
                </select>
            </div>

            <!-- Przyciski -->
            <div class="flex space-x-2">
                <button type="submit" class="bg-gray-200 text-black px-4 py-2 rounded-lg hover:bg-gray-100 transition-all">Szukaj</button>
                <a href="{{ route('admin.providers.searchFilterP') }}" class="bg-gray-200 text-black px-4 py-2 rounded-lg hover:bg-gray-100 transition-all">Resetuj</a>
            </div>
        </form>

        <!-- Tabela z listą klientów -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-gray-600">#</th>
                    <th class="py-3 px-6 text-left text-gray-600">
                        <a href="{{ route('admin.providers.searchFilterP', array_merge(request()->query(), ['sortBy' => 'name', 'sortOrder' => request('sortOrder') === 'asc' ? 'desc' : 'asc'])) }}">
                            Imię
                            @if(request('sortBy') == 'name')
                                <span>{{ request('sortOrder') === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="py-3 px-6 text-left text-gray-600">
                        <a href="{{ route('admin.providers.searchFilterP', array_merge(request()->query(), ['sortBy' => 'email', 'sortOrder' => request('sortOrder') === 'asc' ? 'desc' : 'asc'])) }}">
                            Email
                            @if(request('sortBy') == 'email')
                                <span>{{ request('sortOrder') === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="py-3 px-6 text-left text-gray-600">Status</th>
                    <th class="py-3 px-6 text-left text-gray-600">Akcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($providers as $index => $provider)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-6 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="py-3 px-6 text-sm text-gray-600">{{ $provider->name }}</td>
                        <td class="py-3 px-6 text-sm text-gray-600">{{ $provider->email }}</td>
                        <td class="py-3 px-6 text-sm text-gray-600">
                            {{ $provider->status == 'active' ? 'Aktywny' : 'Zablokowany' }}
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex space-x-2">
                                <!-- Akcja zablokuj -->
                                <form action="{{ route('admin.providers.block', $provider->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-all">
                                        Zablokuj
                                    </button>
                                </form>

                                <!-- Akcja aktywuj -->
                                <form action="{{ route('admin.providers.active', $provider->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-all">
                                        Aktywuj
                                    </button>
                                </form>

                                <!-- Akcja usuń -->
                                <form action="{{ route('admin.providers.delete', $provider->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirmDeletion('{{ $provider->name }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-all">
                                        Usuń
                                    </button>
                                </form>

                                @if(isset($provider->id))
                                    <form action="{{ route('admin.showServices', $provider->id) }}" method="GET" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded-md hover:bg-yellow-600 transition-all">
                                            Usługi
                                        </button>
                                    </form>
                                @else
                                    <p>Błąd: Brak ID dostawcy.</p>
                                @endif


                                <!-- Skrypt potwierdzający usunięcie -->
                                <script>
                                    function confirmDeletion(providerName) {
                                        return confirm('Czy na pewno chcesz usunąć użytkownika "' + providerName + '" z bazy danych?');
                                    }
                                </script>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <footer class="py-4 text-center text-sm text-gray-600 bg-gray-100 mt-8">
        BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.
    </footer>
@endsection
