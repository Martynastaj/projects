<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $table = 'availabilities';

    // Określenie, które kolumny mogą być masowo wypełniane
    protected $fillable = ['provider_id', 'date', 'time'];

    /**
     * Relacja do modelu User (usługodawcy).
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }
}
