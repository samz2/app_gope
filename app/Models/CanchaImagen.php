<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class CanchaImagen extends Model
{
    protected $fillable = ['cancha_id', 'ruta', 'principal'];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }
}
