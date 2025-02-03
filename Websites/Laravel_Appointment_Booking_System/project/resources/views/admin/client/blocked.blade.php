<!-- resources/views/admin/client/blocked.blade.php -->

@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Twoje konto zostało zablokowane') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white shadow-sm rounded-lg p-6">
        <p class="text-center text-red-500">Twoje konto zostało zablokowane przez administratora. Skontaktuj się z administratorem, aby uzyskać więcej informacji.</p>
    </div>
@endsection
