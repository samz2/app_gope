<?php

namespace App\Http\Controllers;
use App\Models\Reserva;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1️⃣ Crear reserva
            $reserva = Reserva::create([
                'cancha_id' => $request->cancha_id,
                'user_id' => auth()->id(),
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'precio_total' => $request->precio_total,
                'estado' => 'pendiente',
            ]);

            // 2️⃣ Crear pago en pendiente
            $pago = Pago::create([
                'reserva_id' => $reserva->id,
                'monto' => $reserva->precio_total,
                'estado' => 'pendiente',
            ]);

            DB::commit();

            return response()->json([
                'reserva' => $reserva,
                'pago' => $pago,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Error al crear la reserva'
            ], 500);
        }
    }
}
