<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nombre',
    ];    
    public function canchas()
    {
        return $this->hasMany(Cancha::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
