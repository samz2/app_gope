<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
     protected $fillable = [
        'cancha_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'precio',
    ];    
    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }
}
