@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Nagłówek sekcji -->
            <h1 class="text-2xl font-semibold mb-6 text-center">Twoje Opinie</h1>

            <!-- Lista opinii -->
            <div class="space-y-6">
                @if ($comments->isEmpty())
                    <!-- Brak opinii -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-800">Brak opinii</h3>
                        <p class="mt-2 text-sm text-gray-600">Nie masz jeszcze żadnych opinii. Dodaj swoją pierwszą opinię!</p>
                    </div>
                @else
                    <!-- Pojedyncza opinia -->
                    @foreach ($comments as $comment)
                        <div class="bg-white shadow-lg rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $comment->service->name }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-600"><strong>Ocena:</strong> {{ $comment->rating }} / 5</p>
                            <p class="mt-2 text-sm text-gray-600">{{ $comment->content }}</p>

                            <!-- Przyciski edycji i usuwania -->
                            <div class="mt-4 flex justify-end space-x-2">
                                <a href="{{ route('client.comments.edit', $comment->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    Edytuj
                                </a>
                                <form action="{{ route('client.comments.delete', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Usuń
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
