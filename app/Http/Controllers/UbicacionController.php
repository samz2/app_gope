<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provincia;
use App\Models\Distrito;

class UbicacionController extends Controller
{
    public function provincias($regionId)
    {
        return Provincia::where('departamento_id', $regionId)->get();
    }

    public function distritos($provinciaId)
    {
        return Distrito::where('provincia_id', $provinciaId)->get();
    }
}
