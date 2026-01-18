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
}
