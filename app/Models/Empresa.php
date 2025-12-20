<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public function canchas()
    {
        return $this->hasMany(Cancha::class);
    }
}
