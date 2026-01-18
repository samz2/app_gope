<?php

namespace App\Http\Controllers;
use App\Models\Cancha;
use App\Models\Empresa;
use Illuminate\Http\Request;

class CanchaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canchas = Cancha::with('empresa')
            ->orderBy('empresa_id')
            ->orderBy('nombre')
            ->paginate(10);

        return view('canchas.index', compact('canchas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('canchas.create', compact('empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre'     => 'required|string|max:255',
            'tipo'       => 'nullable|string|max:50',
            'activa'     => 'nullable|boolean',
        ]);

        Cancha::create([
            'empresa_id' => $request->empresa_id,
            'nombre'     => $request->nombre,
            'tipo'       => $request->tipo,
            'activa'     => $request->has('activa'),
        ]);

        return redirect()
            ->route('canchas.index')
            ->with('success', 'Cancha creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cancha $cancha)
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('canchas.edit', compact('cancha', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cancha $cancha)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre'     => 'required|string|max:255',
            'tipo'       => 'nullable|string|max:50',
            'activa'     => 'nullable|boolean',
        ]);

        $cancha->update([
            'empresa_id' => $request->empresa_id,
            'nombre'     => $request->nombre,
            'tipo'       => $request->tipo,
            'activa'     => $request->has('activa'),
        ]);

        return redirect()
            ->route('canchas.index')
            ->with('success', 'Cancha actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cancha $cancha)
    {
        $cancha->delete();

        return redirect()
            ->route('canchas.index')
            ->with('success', 'Cancha eliminada correctamente');
    }
}
