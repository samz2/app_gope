<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
