<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = true;

    protected $fillable = ['providerID', 'client_id', 'name', 'duration', 'price'];

    /**
     * Relacja: Usługa należy do klienta.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function provider(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'providerID', 'id')
            ->where('role', 'provider');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

}
