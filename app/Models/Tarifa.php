<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Tarifa extends Model
{
    protected $fillable = [
        'cancha_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'precio',
    ];

    protected $casts = [
        'dia_semana' => 'array', // 🔥 IMPORTANTE
    ];

    // ✅ Texto bonito de los días (Dom, Lun, Mar...)
    protected function diasTexto(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->dia_semana)
                return '';

            $nombres = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

            return collect($this->dia_semana)
                ->map(fn($d) => $nombres[$d] ?? '')
                ->implode(', ');
        });
    }
}
