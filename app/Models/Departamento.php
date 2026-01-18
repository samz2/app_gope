<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public function provincias()
    {
        return $this->hasMany(Provincia::class, 'departamento_id');
    }
}
