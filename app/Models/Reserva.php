<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'empresa_id',
        'cancha_id',
        'cliente_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'precio',
        'estado',
        // otros campos...
        'pagado',
        'monto_pagado',
        'tipo_pago',
        'codigo_promocion',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    protected $casts = [
        'pagado' => 'boolean',
        'fecha_pago' => 'datetime',
    ];

    public function cobro()
    {
        return $this->hasOne(Cobro::class);
    }



}

