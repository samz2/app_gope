<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    protected $fillable = [
        'empresa_id',
        'nombre',
        'tipo',
        'activa',
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function imagenes()
    {
        return $this->hasMany(CanchaImagen::class);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(CanchaImagen::class)->where('principal', true);
    }
}
