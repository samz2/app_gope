<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
