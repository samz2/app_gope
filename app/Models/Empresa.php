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

}
