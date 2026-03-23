<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Notifications\NuevaReservaNotification;
use App\Models\User;
use App\Models\Cobro;

class ReservaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role->nombre === 'empresa') {
            $reservas = Reserva::with(['cancha', 'cliente'])
                ->where('empresa_id', $user->empresa->id)
                ->orderBy('fecha', 'desc')
                ->orderBy('hora_inicio', 'desc')
                ->paginate(10);
        } else {
            $reservas = Reserva::with(['empresa', 'cancha', 'cliente'])
                ->orderBy('fecha', 'desc')
                ->orderBy('hora_inicio', 'desc')
                ->paginate(10);
        }

        return view('reservas.index', compact('reservas'));
    }

    public function create()
    {
        $user = auth()->user();

        // 🔹 Cargar canchas activas según el rol
        if ($user->role->nombre === 'empresa') {

            $empresa = $user->empresa;

            // Solo canchas activas de esa empresa
            $canchas = $empresa->canchas()
                ->where('activa', 1)
                ->orderBy('nombre')
                ->get();

        } else {

            $empresa = null;

            // Todas las canchas activas
            $canchas = Cancha::where('activa', 1)
                ->orderBy('nombre')
                ->get();
        }

        // 🔹 Solo clientes activos
        $clientes = Cliente::where('estado', 'activo')
            ->orderBy('nombres')
            ->get();

        return view('reservas.create', compact('empresa', 'canchas', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        $canchaId = $request->cancha_id;
        $fecha = $request->fecha;
        $horaIni = $request->hora_inicio;
        $horaFin = $request->hora_fin;

        // 🗓️ Día de la semana (0=Domingo ... 6=Sábado)
        $diaSemana = (string) Carbon::parse($fecha)->dayOfWeek;

        /* -------------------------------------------------
         | 1️⃣ VALIDAR QUE NO EXISTA RESERVA CRUZADA
         -------------------------------------------------*/
        $existeReserva = Reserva::where('cancha_id', $canchaId)
            ->where('fecha', $fecha)
            ->where(function ($q) use ($horaIni, $horaFin) {
                $q->whereBetween('hora_inicio', [$horaIni, $horaFin])
                    ->orWhereBetween('hora_fin', [$horaIni, $horaFin])
                    ->orWhere(function ($q2) use ($horaIni, $horaFin) {
                        $q2->where('hora_inicio', '<=', $horaIni)
                            ->where('hora_fin', '>=', $horaFin);
                    });
            })
            ->exists();

        if ($existeReserva) {
            return back()->withErrors([
                'hora_inicio' => 'Este horario ya está reservado.'
            ])->withInput();
        }

        /* -------------------------------------------------
         | 2️⃣ BUSCAR TARIFA VÁLIDA (MODELO JSON NUEVO)
         -------------------------------------------------*/
        $tarifa = Tarifa::where('cancha_id', $canchaId)
            ->whereJsonContains('dia_semana', $diaSemana)
            ->where('hora_inicio', '<=', $horaIni)
            ->where('hora_fin', '>', $horaIni)
            ->first();

        if (!$tarifa) {
            return back()->withErrors([
                'hora_inicio' => 'No existe tarifa configurada para este día y horario.'
            ])->withInput();
        }

        /* -------------------------------------------------
         | 3️⃣ VALIDAR QUE NO SE SALGA DEL BLOQUE
         -------------------------------------------------*/
        if ($horaFin > $tarifa->hora_fin) {
            return back()->withErrors([
                'hora_fin' => 'El horario seleccionado excede el bloque permitido (' .
                    substr($tarifa->hora_inicio, 0, 5) . ' - ' .
                    substr($tarifa->hora_fin, 0, 5) . ')'
            ])->withInput();
        }

        /* -------------------------------------------------
         | 4️⃣ CALCULAR PRECIO REAL (NO CONFIAR EN EL FORM)
         -------------------------------------------------*/
        $inicio = Carbon::createFromFormat('H:i', $horaIni);
        $fin = Carbon::createFromFormat('H:i', $horaFin);

        $minutos = $inicio->diffInMinutes($fin);

        if ($minutos <= 0) {
            return back()->withErrors([
                'hora_inicio' => 'Horario inválido.'
            ])->withInput();
        }

        $horas = $minutos / 60;
        $total = round($horas * $tarifa->precio, 2);

        $cancha = Cancha::findOrFail($canchaId);
        $empresaId = $cancha->empresa_id;

        /* -------------------------------------------------
         | 5️⃣ GUARDAR RESERVA (PRECIO SEGURO)
         -------------------------------------------------*/
        $reserva = Reserva::create([
            'empresa_id' => $empresaId,   // 🔥 ESTE ERA EL QUE FALTABA
            'cliente_id' => $request->cliente_id,
            'cancha_id' => $canchaId,
            'fecha' => $fecha,
            'hora_inicio' => $horaIni,
            'hora_fin' => $horaFin,
            'precio' => $total, // 🔥 PRECIO CALCULADO EN BACKEND
        ]);

        // 🔔 Notificar a los usuarios de la empresa
        $usuariosEmpresa = User::where('empresa_id', $reserva->empresa_id)->get();

        foreach ($usuariosEmpresa as $usuario) {
            $usuario->notify(new NuevaReservaNotification($reserva));
        }
        return redirect()
            ->route('reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }



    public function edit(Reserva $reserva)
    {
        $user = auth()->user();

        // 🔒 Seguridad empresa
        if ($user->role->nombre === 'empresa' && $reserva->empresa_id != $user->empresa->id) {
            abort(403);
        }

        $canchas = Cancha::where('empresa_id', $reserva->empresa_id)->get();
        $clientes = Cliente::orderBy('nombres')->get();

        return view('reservas.edit', compact('reserva', 'canchas', 'clientes'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $user = auth()->user();

        // 🔒 Seguridad empresa
        if ($user->role->nombre === 'empresa' && $reserva->empresa_id != $user->empresa->id) {
            abort(403);
        }

        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'precio' => 'required|numeric',
            'estado' => 'required',
        ]);

        // 🔒 VALIDAR CRUCE DE HORARIOS (excluyendo esta reserva)
        $existe = Reserva::where('cancha_id', $request->cancha_id)
            ->where('fecha', $request->fecha)
            ->where('id', '!=', $reserva->id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                    ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('hora_inicio', '<=', $request->hora_inicio)
                            ->where('hora_fin', '>=', $request->hora_fin);
                    });
            })
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['hora_inicio' => 'Esta cancha ya tiene una reserva en ese horario'])
                ->withInput();
        }

        $reserva->update([
            'cancha_id' => $request->cancha_id,
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'precio' => $request->precio,
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('reservas.index')
            ->with('success', 'Reserva actualizada correctamente');
    }

    public function destroy(Reserva $reserva)
    {
        $user = auth()->user();

        // 🔒 Seguridad empresa
        if ($user->role->nombre === 'empresa' && $reserva->empresa_id != $user->empresa->id) {
            abort(403);
        }

        $reserva->delete();

        return redirect()
            ->route('reservas.index')
            ->with('success', 'Reserva eliminada correctamente');
    }

    public function calendarioPorCancha(Cancha $cancha)
    {
        // Seguridad: solo la empresa dueña puede ver esta cancha
        if ($cancha->empresa_id !== auth()->user()->empresa->id) {
            abort(403);
        }

        return view('empresadashboard.calendario', compact('cancha'));
    }

    public function eventosPorCancha(Cancha $cancha)
    {
        // Seguridad
        if ($cancha->empresa_id !== auth()->user()->empresa->id) {
            abort(403);
        }

        $reservas = Reserva::where('cancha_id', $cancha->id)->get();

        $eventos = $reservas->map(function ($reserva) {
            return [
                'title' => 'Reservado',
                'start' => $reserva->fecha . 'T' . $reserva->hora_inicio,
                'end' => $reserva->fecha . 'T' . $reserva->hora_fin,
            ];
        });

        return response()->json($eventos);
    }

    public function calendarioDashboard()
    {
        $user = auth()->user();

        if ($user->role->nombre !== 'empresa') {
            abort(403);
        }

        return view('empresadashboard.calendario');
    }

    public function eventosDashboard()
    {
        $user = auth()->user();

        if ($user->role->nombre !== 'empresa') {
            abort(403);
        }

        $empresaId = $user->empresa->id;

        $reservas = Reserva::select(
            'fecha',
            DB::raw('COUNT(*) as total')
        )
            ->where('empresa_id', $empresaId)
            ->groupBy('fecha')
            ->get();

        $eventos = $reservas->map(function ($r) {
            return [
                'title' => $r->total . ' reservas',
                'start' => $r->fecha,
                'url' => route('reservas.dashboard.detalle', $r->fecha),
            ];
        });

        return response()->json($eventos);
    }

    public function detallePorDia($fecha)
    {
        $user = auth()->user();

        if ($user->role->nombre !== 'empresa') {
            abort(403);
        }

        $empresaId = $user->empresa->id;

        $reservas = Reserva::with(['cancha', 'cliente'])
            ->where('empresa_id', $empresaId)
            ->where('fecha', $fecha)
            ->orderBy('hora_inicio')
            ->get();

        return view('empresadashboard.detalle_dia', compact('reservas', 'fecha'));
    }
    public function verificarDisponibilidad(Request $request)
    {
        $canchaId = $request->cancha_id;
        $horaIni = $request->hora_inicio;
        $horaFin = $request->hora_fin;
        $fecha = $request->fecha;

        if (!$canchaId || !$horaIni || !$horaFin || !$fecha) {
            return response()->json(['disponible' => false]);
        }

        // 🟢 Día de la semana
        $diaSemana = (string) Carbon::parse($fecha)->dayOfWeek;

        // 🔎 1. Buscar tarifa válida
        $tarifa = Tarifa::where('cancha_id', $canchaId)
            ->whereJsonContains('dia_semana', $diaSemana)
            ->where('hora_inicio', '<=', $horaIni)
            ->where('hora_fin', '>', $horaIni)
            ->first();

        // ❌ Primero validar que exista tarifa
        if (!$tarifa) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'No existe tarifa para este horario'
            ]);
        }

        // ❌ Luego validar que no se salga del bloque
        if ($horaFin > $tarifa->hora_fin) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'El horario excede el bloque permitido (' .
                    substr($tarifa->hora_inicio, 0, 5) . ' - ' .
                    substr($tarifa->hora_fin, 0, 5) . ')'
            ]);
        }

        // 🔎 2. Verificar cruce con reservas
        $existeReserva = Reserva::where('cancha_id', $canchaId)
            ->where('fecha', $fecha)
            ->where(function ($q) use ($horaIni, $horaFin) {
                $q->whereBetween('hora_inicio', [$horaIni, $horaFin])
                    ->orWhereBetween('hora_fin', [$horaIni, $horaFin])
                    ->orWhere(function ($q2) use ($horaIni, $horaFin) {
                        $q2->where('hora_inicio', '<=', $horaIni)
                            ->where('hora_fin', '>=', $horaFin);
                    });
            })
            ->exists();

        if ($existeReserva) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'Este horario ya está reservado'
            ]);
        }

        // ✅ Todo correcto
        return response()->json([
            'disponible' => true,
            'mensaje' => 'Horario disponible',
            'bloque' => substr($tarifa->hora_inicio, 0, 5) . ' - ' . substr($tarifa->hora_fin, 0, 5),
            'precio_hora' => $tarifa->precio
        ]);
    }


    public function buscarPrecio(Request $request)
    {
        $canchaId = $request->cancha_id;
        $fecha = $request->fecha;
        $horaIni = $request->hora_inicio;
        $horaFin = $request->hora_fin;

        if (!$canchaId || !$fecha || !$horaIni || !$horaFin) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'Datos incompletos'
            ]);
        }

        // Día de la semana
        $diaSemana = (string) Carbon::parse($fecha)->dayOfWeek;

        // Buscar tarifa válida
        $tarifa = Tarifa::where('cancha_id', $canchaId)
            ->whereJsonContains('dia_semana', $diaSemana)
            ->where('hora_inicio', '<=', $horaIni)
            ->where('hora_fin', '>', $horaIni)
            ->first();

        if (!$tarifa) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'No existe tarifa para este horario'
            ]);
        }

        // Validar que no se salga del bloque
        if ($horaFin > $tarifa->hora_fin) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'El horario excede el bloque permitido'
            ]);
        }

        // Calcular horas
        $inicio = Carbon::createFromFormat('H:i', $horaIni);
        $fin = Carbon::createFromFormat('H:i', $horaFin);

        $horas = $inicio->floatDiffInHours($fin);

        // Calcular total
        $total = $horas * $tarifa->precio;

        return response()->json([
            'disponible' => true,
            'total' => $total,
            'precio_hora' => $tarifa->precio,
            'horas' => $horas
        ]);
    }
    public function pagar(Request $request, Reserva $reserva)
    {

        $request->validate([
            'monto_pagado' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string',
            'codigo_promocional' => 'nullable|string',
        ]);

        // 🔒 Seguridad: solo la empresa dueña
        if (
            auth()->user()->role->nombre === 'empresa' &&
            $reserva->empresa_id !== auth()->user()->empresa->id
        ) {
            abort(403);
        }

        // 🚫 Ya pagada
        if ($reserva->pagado) {
            return back()->with('warning', 'La reserva ya está pagada');
        }

        // ✅ AQUÍ VA TU CÓDIGO
        $cobro = Cobro::create([
            'reserva_id' => $reserva->id,
            'empresa_id' => $reserva->empresa_id,
            'monto' => $request->monto_pagado,
            'metodo_pago' => $request->metodo_pago,
            'estado' => 'pagado',
            'fecha_pago' => now(),
            'referencia' => $request->codigo_promocional,
        ]);


        // Marcar reserva como pagada
        $reserva->update([
            'pagado' => true,
        ]);

        return redirect()
            ->route('reservas.index')
            ->with('success', 'Pago registrado correctamente');
    }

    public function show(Reserva $reserva)
    {
        $user = auth()->user();

        if (
            $user->role->nombre === 'empresa' &&
            $reserva->empresa_id !== $user->empresa->id
        ) {
            abort(403);
        }

        return view('reservas.partials.show', compact('reserva'));
    }



}
