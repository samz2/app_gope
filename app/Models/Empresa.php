<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nombre',
        'documento',
        'representante',
        'estado',
        'telefono',
        'direccion',
        'categoria',
        'latitud',
        'longitud',
        'distrito_id',
    ];
    public function canchas()
    {
        return $this->hasMany(Cancha::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nombre', 'like', "%$search%")
            ->orWhere('documento', 'like', "%$search%")
            ->orWhere('representante', 'like', "%$search%")
            ->orWhere('telefono', 'like', "%$search%");
        });
    }
    public function getDepartamentoNombreAttribute()
    {
        return optional(optional(optional($this->distrito)->provincia)->departamento)->nombre;
    }

    public function getProvinciaNombreAttribute()
    {
        return optional(optional($this->distrito)->provincia)->nombre;
    }

    public function getDistritoNombreAttribute()
    {
        return optional($this->distrito)->nombre;
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

}
