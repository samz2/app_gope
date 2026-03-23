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
        $user = auth()->user();

        if ($user->role->nombre === 'empresa') {
            // Solo canchas de su empresa
            $canchas = Cancha::with('empresa')
                ->where('empresa_id', $user->empresa->id)
                ->orderBy('nombre')
                ->get();
        } else {
            // Admin ve todas
            $canchas = Cancha::with('empresa')
                ->orderBy('empresa_id')
                ->orderBy('nombre')
                ->get();
        }

        return view('canchas.index', compact('canchas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->role->nombre === 'admin') {
            $empresas = Empresa::orderBy('nombre')->get();
        } else {
            $empresas = collect(); // vacío, no se usa
        }

        return view('canchas.create', compact('empresas'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:50',
            'activa' => 'nullable|boolean',
        ]);

        // 🔒 Si es empresa, usamos SU empresa sí o sí
        $empresaId = $user->role->nombre === 'empresa'
            ? $user->empresa->id
            : $request->empresa_id;

        $cancha = Cancha::create([
            'empresa_id' => $empresaId,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'activa' => $request->has('activa'),
        ]);

        if ($request->hasFile('imagenes')) {

            foreach ($request->file('imagenes') as $i => $imagen) {

                $ruta = $imagen->store('canchas', 'public');

                $cancha->imagenes()->create([
                    'ruta' => $ruta,
                    'principal' => $i === 0 // la primera como principal
                ]);
            }
        }

        return redirect()
            ->route('canchas.index')
            ->with('success', 'Cancha creada correctamente');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cancha $cancha)
    {
        $user = auth()->user();

        if ($user->role->nombre === 'empresa' && $cancha->empresa_id != $user->empresa->id) {
            abort(403);
        }

        $empresas = Empresa::orderBy('nombre')->get();

        return view('canchas.edit', compact('cancha', 'empresas'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cancha $cancha)
    {
        $user = auth()->user();

        // 🔒 Seguridad: empresa solo puede modificar sus propias canchas
        if ($user->role->nombre === 'empresa' && $cancha->empresa_id != $user->empresa->id) {
            abort(403);
        }

        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:50',
            'activa' => 'nullable|boolean',
            'imagenes.*' => 'image|mimes:jpg,png,webp|max:2048',
        ]);

        // 🔒 Si es empresa, forzamos su empresa
        $empresaId = $user->role->nombre === 'empresa'
            ? $user->empresa->id
            : $request->empresa_id;

        // 🔹 Actualizar datos básicos
        $cancha->update([
            'empresa_id' => $empresaId,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
        ]);

        // 🖼️ Guardar NUEVAS imágenes (sin borrar las existentes)
        if ($request->hasFile('imagenes')) {

            $tienePrincipal = $cancha->imagenes()
                ->where('principal', 1)
                ->exists();

            foreach ($request->file('imagenes') as $index => $imagen) {

                $ruta = $imagen->store('canchas', 'public');

                $cancha->imagenes()->create([
                    'ruta' => $ruta,
                    'principal' => !$tienePrincipal && $index === 0,
                ]);
            }
        }

        return redirect()
            ->route('canchas.index')
            ->with('success', 'Cancha actualizada correctamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cancha $cancha)
    {
        $user = auth()->user();

        // 🔒 Seguridad
        if ($user->role->nombre === 'empresa' && $cancha->empresa_id != $user->empresa->id) {
            abort(403);
        }

        // 🚫 Si tiene reservas → NO permitir desactivar
        if ($cancha->reservas()->exists()) {
            return redirect()
                ->route('canchas.index')
                ->with(
                    'error',
                    'No se puede desactivar la cancha porque tiene reservas asociadas'
                );
        }

        // 🚫 Si ya está inactiva
        if (!$cancha->activa) {
            return redirect()
                ->route('canchas.index')
                ->with('warning', 'La cancha ya se encuentra inactiva');
        }

        // ✅ Desactivar
        $cancha->update([
            'activa' => false
        ]);

        return redirect()
            ->route('canchas.index')
            ->with('success', 'Cancha desactivada correctamente');
    }

    public function toggle(Cancha $cancha)
    {
        $user = auth()->user();

        if ($user->role->nombre === 'empresa' && $cancha->empresa_id != $user->empresa->id) {
            abort(403);
        }

        // Si intenta desactivar y tiene reservas
        if ($cancha->activa && $cancha->reservas()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede desactivar la cancha porque tiene reservas'
            ], 422);
        }

        $cancha->update([
            'activa' => !$cancha->activa
        ]);

        return response()->json([
            'success' => true,
            'activa' => $cancha->activa
        ]);
    }


}
