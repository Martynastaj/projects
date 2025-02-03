<?php

use Illuminate\Support\Facades\Route;
use App\Models\Appointment;

Route::middleware('auth:sanctum')->get('/appointments', function () {
    return Appointment::where('client_id', auth()->id())
    ->get()
    ->map(function ($appointment) {
        return [
        'title' => $appointment->service->name,
        'start' => $appointment->date->toDateTimeString(),
        'end' => $appointment->date->addMinutes($appointment->service->duration)->toDateTimeString(),
        'color' => '#4caf50', // Kolor wydarzenia
        ];
    });
});
