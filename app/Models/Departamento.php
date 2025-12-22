<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';

    protected $fillable = ['pais_id', 'nombre'];

    public function provincias()
    {
        return $this->hasMany(Provincia::class);
    }
}
