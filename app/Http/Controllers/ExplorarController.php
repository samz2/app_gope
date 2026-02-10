<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class ExplorarController extends Controller
{
    public function index()
    {
        return view('explorar.index');
    }

    public function canchasCercanas(Request $request)
{
    $lat = $request->lat;
    $lng = $request->lng;
    $radio = $request->radio ?? 5;
    $tipo = $request->tipo;
    $precio = $request->precio;

    $empresas = Empresa::selectRaw("
            empresas.*,
            (
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitud)) *
                    cos(radians(longitud) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitud))
                )
            ) AS distancia
        ", [$lat, $lng, $lat])
        ->having('distancia', '<=', $radio)
        ->orderBy('distancia')
        ->with(['canchas' => function ($q) use ($tipo, $precio) {
            if ($tipo) {
                $q->where('tipo', $tipo);
            }
            if ($precio) {
                $q->where('precio_hora', '<=', $precio);
            }
        }])
        ->get()
        ->filter(function ($e) {
            return $e->canchas->count() > 0;
        })
        ->values();

        return response()->json($empresas);
    }


}
