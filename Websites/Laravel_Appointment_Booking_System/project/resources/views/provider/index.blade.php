@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <h2 class="mb-3 font-weight-bold">Lista Twoich Usług</h2>

        <!-- Przycisk z większą przerwą poniżej -->
        <a href="{{ route('provider.add_service') }}" class="btn btn-primary btn-rounded mb-4">
            Dodaj nową usługę
        </a>

        <!-- Tabela z większym marginesem powyżej -->
        <div class="table-responsive mt-3">
            <table class="table table-hover w-100">
                <thead>
                <tr>
                    <th scope="col" class="border-bottom">Nazwa</th>
                    <th scope="col" class="border-bottom">Czas trwania (min)</th>
                    <th scope="col" class="border-bottom">Cena (PLN)</th>
                    <th scope="col" class="border-bottom">Akcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($services as $service)
                    <tr class="table-row">
                        <td class="align-middle">{{ $service->name }}</td>
                        <td class="align-middle">{{ $service->duration }}</td>
                        <td class="align-middle">{{ number_format($service->price, 2) }}</td>
                        <td class="align-middle">
                            <!-- Przyciski Edytuj i Usuń w jednej linii -->
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('provider.edit_service', $service->id) }}"
                                   class="btn btn-warning btn-rounded text-white">
                                    Edytuj
                                </a>
                                <form action="{{ route('provider.delete_service', $service->id) }}"
                                      method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-danger btn-rounded text-white"
                                            onclick="return confirm('Czy na pewno chcesz usunąć tę usługę?')">
                                        Usuń
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .container-fluid {
            max-width: 100%;
        }

        h2 {
            font-size: 1.75rem;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #bd2130;
            border-color: #b21f2d;
        }

        .btn-rounded {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
        }

        .btn {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .table {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 500;
            color: #666;
            border-bottom-width: 1px;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem;
        }

        .table-row {
            border-bottom: 1px solid #ddd;
        }

        .table-row:last-child {
            border-bottom: none; /* Brak linii na ostatnim wierszu */
        }

        .mb-4 {
            margin-bottom: 2rem !important; /* Większa przerwa poniżej przycisku */
        }

        .mt-3 {
            margin-top: 1.5rem !important; /* Przerwa powyżej tabeli */
        }

        .gap-2 > * {
            margin-right: 0.5rem;
        }

        .gap-2 > *:last-child {
            margin-right: 0;
        }

        .d-flex {
            display: flex; /* Ustawienie przycisków obok siebie */
        }

        .align-items-center {
            align-items: center;
        }
    </style>
@endsection
