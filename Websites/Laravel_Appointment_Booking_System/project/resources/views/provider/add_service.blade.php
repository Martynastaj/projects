@extends('layouts.app')

@section('content')
    <div class="container mt-4 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="w-100" style="max-width: 600px;">
            <h1 class="mb-4 text-center font-weight-bold">Dodaj nową usługę</h1>

            <form action="{{ route('provider.add_service') }}" method="POST" class="p-4 ml-12 rounded shadow bg-white">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nazwa usługi</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Wpisz nazwę usługi" required>
                </div>
                <div class="form-group mb-3">
                    <label for="duration" class="form-label">Czas trwania (minuty)</label>
                    <input type="number" name="duration" id="duration" class="form-control" placeholder="Wpisz czas w minutach" required>
                </div>
                <div class="form-group mb-3">
                    <label for="price" class="form-label">Cena (PLN)</label>
                    <input type="number" name="price" id="price" class="form-control" placeholder="Wpisz cenę w PLN" required>
                </div>
                <button type="submit" class="btn btn-success btn-rounded w-100">Dodaj</button>
            </form>
        </div>
    </div>

    <style>
        .container {
            min-height: 100vh; /* Kontener zajmuje całą wysokość widoku */
        }

        h1 {
            font-size: 1.75rem;
            font-weight: bold;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        form {
            background-color: #f8f9fa;
        }

        .shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
