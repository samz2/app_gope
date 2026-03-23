<?php

namespace App\Http\Controllers;
use App\Models\Cancha;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Carbon\Carbon;
class TarifaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cancha $cancha)
    {
        $tarifas = $cancha->tarifas()
            ->orderBy('hora_inicio')
            ->get();

        return view('tarifas.index', compact('cancha', 'tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Cancha $cancha)
    {
        return view('tarifas.create', compact('cancha'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Cancha $cancha)
    {
        $request->validate([
            'dia_semana' => 'required|array|min:1',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'precio' => 'required|numeric|min:0',
        ]);

        // 🟢 Normalizar días (int + ordenados)
        $dias = array_map('intval', $request->dia_semana);
        sort($dias);

        $diasTexto = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        // 🔴 1. TRAER TODAS LAS TARIFAS CON MISMO HORARIO EN ESA CANCHA
        $tarifasMismoHorario = Tarifa::where('cancha_id', $cancha->id)
            ->where('hora_inicio', $request->hora_inicio)
            ->where('hora_fin', $request->hora_fin)
            ->get();

        // 🔴 2. VALIDAR BLOQUE EXACTO EN PHP (COMPARACIÓN REAL)
        foreach ($tarifasMismoHorario as $tarifa) {
            $diasExistentes = $tarifa->dia_semana;
            sort($diasExistentes);

            if ($diasExistentes === $dias) {
                return back()->withErrors([
                    'hora_inicio' => '⚠️ Ya existe exactamente una tarifa con esos mismos días y horario.'
                ])->withInput();
            }
        }

        // 🔴 3. VALIDAR CRUCES POR CADA DÍA
        foreach ($dias as $dia) {

            $existeCruce = Tarifa::where('cancha_id', $cancha->id)
                ->whereJsonContains('dia_semana', $dia)
                ->where(function ($q) use ($request) {
                    // Regla correcta de cruce
                    $q->where('hora_inicio', '<', $request->hora_fin)
                        ->where('hora_fin', '>', $request->hora_inicio);
                })
                ->exists();

            if ($existeCruce) {
                return back()->withErrors([
                    'hora_inicio' => 'El horario se cruza el día ' . $diasTexto[$dia] . ' con una tarifa existente.'
                ])->withInput();
            }
        }

        // ✅ 4. GUARDAR SOLO SI PASÓ TODO
        Tarifa::create([
            'cancha_id' => $cancha->id,
            'dia_semana' => $dias,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'precio' => $request->precio,
        ]);

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
            'dia_semana' => 'required|array|min:1',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'precio' => 'required|numeric|min:0',
        ]);

        $tarifa->update([
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'precio' => $request->precio,
        ]);

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

    public function buscarPrecio(Request $request)
    {
        $canchaId = $request->cancha_id;
        $horaIni = $request->hora_inicio;
        $horaFin = $request->hora_fin;
        $fecha = $request->fecha;

        if (!$canchaId || !$horaIni || !$horaFin || !$fecha) {
            return response()->json(['total' => null]);
        }

        // Día de la semana (0=Dom, 1=Lun...)
        $diaSemana = Carbon::parse($fecha)->dayOfWeek;

        // 🔎 Buscar bloque que contenga ese día y esa hora
        $tarifa = Tarifa::where('cancha_id', $canchaId)
            ->whereJsonContains('dia_semana', $diaSemana)
            ->where('hora_inicio', '<=', $horaIni)
            ->where('hora_fin', '>', $horaIni)
            ->first();

        // ❌ No existe tarifa
        if (!$tarifa) {
            return response()->json([
                'total' => null,
                'mensaje' => 'No existe tarifa para ese día y horario'
            ]);
        }

        // ⛔ Verificar que no se salga del bloque
        if ($horaFin > $tarifa->hora_fin) {
            return response()->json([
                'total' => null,
                'mensaje' => 'El horario excede el bloque permitido'
            ]);
        }

        // ⏱️ Calcular duración
        $inicio = Carbon::createFromFormat('H:i', $horaIni);
        $fin = Carbon::createFromFormat('H:i', $horaFin);

        $minutos = $inicio->diffInMinutes($fin);

        if ($minutos <= 0) {
            return response()->json(['total' => null]);
        }

        $horas = $minutos / 60;

        // 💰 Total
        $total = $horas * $tarifa->precio;

        return response()->json([
            'total' => round($total, 2),
            'precio_hora' => $tarifa->precio,
            'horas' => $horas,
            'bloque' => substr($tarifa->hora_inicio, 0, 5) . ' - ' . substr($tarifa->hora_fin, 0, 5)
        ]);
    }


}
