<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $fillable = [
        'reserva_id',
        'empresa_id',      // 👈 importante
        'monto',
        'metodo_pago',
        'estado',
        'fecha_pago',
        'referencia',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
