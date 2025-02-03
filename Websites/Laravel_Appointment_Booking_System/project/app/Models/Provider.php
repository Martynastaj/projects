<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Relacja: Usługodawca ma wiele usług.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'providerID');
    }

    public function bookings()
    {
        return $this->hasMany(Rezerwacja::class, 'provider_id');
    }



}
