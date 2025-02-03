<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezerwacja extends Model
{
    use HasFactory;

    // Nazwa tabeli w bazie danych
    protected $table = 'rezerwacje';

    // Kolumny, które mogą być masowo przypisywane
    protected $fillable = ['date', 'time', 'service_id', 'client_id', 'provider_id'];

    // Jeśli potrzebujesz relacji, dodaj je tutaj, np.:
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
