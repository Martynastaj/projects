<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'service_id',
        'content',
        'rating',
    ];
    /**
     * Relacja: Komentarz należy do klienta.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    /**
     * Relacja: Komentarz dotyczy usługi.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
