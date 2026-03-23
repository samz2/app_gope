<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use Illuminate\Http\Request;

class CobroController extends Controller
{
    /**
     * Vista de cobros para empresa
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role->nombre !== 'empresa') {
            abort(403);
        }

        $cobros = Cobro::with([
            'reserva.cliente',
            'reserva.cancha',
        ])
            ->where('empresa_id', $user->empresa->id)
            ->orderByDesc('fecha_pago')
            ->get();

        return view('cobros.index', compact('cobros'));
    }

    /**
     * (Preparado para luego) Marcar cobro como pagado
     */
    public function marcarPagado(Cobro $cobro)
    {
        $user = auth()->user();

        // Seguridad: solo empresa dueña
        if (
            $user->role->nombre !== 'empresa' ||
            $cobro->reserva->cancha->empresa_id !== $user->empresa->id
        ) {
            abort(403);
        }

        $cobro->update([
            'estado' => 'pagado'
        ]);

        return redirect()
            ->back()
            ->with('success', 'Cobro marcado como pagado');
    }
}
