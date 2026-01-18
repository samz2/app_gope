<?php

namespace App\Http\Controllers;
use App\Models\Cancha;
use App\Models\Tarifa;
use Illuminate\Http\Request;

class TarifaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cancha $cancha)
    {
        $tarifas = $cancha->tarifas()
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        return view('tarifas.index', compact('cancha', 'tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Cancha $cancha)
    {
        return view('tarifas.create', compact('cancha'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Cancha $cancha)
    {
        $request->validate([
            'dia_semana'  => 'required|integer|min:0|max:6',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'precio'      => 'required|numeric|min:0',
        ]);

        $cancha->tarifas()->create($request->all());

        return redirect()
            ->route('canchas.tarifas.index', $cancha)
            ->with('success', 'Tarifa creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cancha $cancha, Tarifa $tarifa)
    {
        return view('tarifas.edit', compact('cancha', 'tarifa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cancha $cancha, Tarifa $tarifa)
    {
        $request->validate([
            'dia_semana'  => 'required|integer|min:0|max:6',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'precio'      => 'required|numeric|min:0',
        ]);

        $tarifa->update($request->all());

        return redirect()
            ->route('canchas.tarifas.index', $cancha)
            ->with('success', 'Tarifa actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cancha $cancha, Tarifa $tarifa)
    {
        $tarifa->delete();

        return redirect()
            ->route('canchas.tarifas.index', $cancha)
            ->with('success', 'Tarifa eliminada');
    }
}
