<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'email',
        'latitud',
        'longitud',
        'estado',
        'distrito_id',

    ];

    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

}
