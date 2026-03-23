<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\Cobro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmpresaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->empresa) {
            abort(403, 'Este usuario no tiene una empresa asignada');
        }

        $empresa = $user->empresa;

        // ============================
        // 📆 Rangos de fechas
        // ============================
        $inicioMesActual = Carbon::now()->startOfMonth();
        $finMesActual = Carbon::now()->endOfMonth();

        $inicioMesAnterior = Carbon::now()->subMonth()->startOfMonth();
        $finMesAnterior = Carbon::now()->subMonth()->endOfMonth();


        // 🏃 Canchas activas
        $cantidadCanchas = Cancha::where('empresa_id', $empresa->id)
            ->where('activa', true)
            ->count();

        // 🏆 Canchas creadas este mes
        $canchasMesActual = Cancha::where('empresa_id', $empresa->id)
            ->whereBetween('created_at', [$inicioMesActual, $finMesActual])
            ->count();

        // 🏆 Canchas creadas mes anterior
        $canchasMesAnterior = Cancha::where('empresa_id', $empresa->id)
            ->whereBetween('created_at', [$inicioMesAnterior, $finMesAnterior])
            ->count();

        // 📈 Variación canchas
        $variacionCanchas = $canchasMesAnterior > 0
            ? (($canchasMesActual - $canchasMesAnterior) / $canchasMesAnterior) * 100
            : ($canchasMesActual > 0 ? 100 : 0);

        // 📅 Reservas de hoy
        $reservasHoy = Reserva::whereDate('fecha', Carbon::today())
            ->whereHas('cancha', function ($q) use ($empresa) {
                $q->where('empresa_id', $empresa->id)
                    ->where('activa', true);
            })
            ->count();

        // 📅 Reservas mes actual
        $reservasMesActual = Reserva::whereBetween('fecha', [$inicioMesActual, $finMesActual])
            ->whereHas('cancha', function ($q) use ($empresa) {
                $q->where('empresa_id', $empresa->id)
                    ->where('activa', true);
            })
            ->count();

        // 📅 Reservas mes anterior
        $reservasMesAnterior = Reserva::whereBetween('fecha', [$inicioMesAnterior, $finMesAnterior])
            ->whereHas('cancha', function ($q) use ($empresa) {
                $q->where('empresa_id', $empresa->id)
                    ->where('activa', true);
            })
            ->count();

        // 📈 Variación reservas
        $variacionReservas = $reservasMesAnterior > 0
            ? (($reservasMesActual - $reservasMesAnterior) / $reservasMesAnterior) * 100
            : ($reservasMesActual > 0 ? 100 : 0);

        // 📊 Reservas por mes (barra)
        $reservasPorMes = Reserva::select(
            DB::raw('MONTH(fecha) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('fecha', now()->year)
            ->whereHas('cancha', function ($q) use ($empresa) {
                $q->where('empresa_id', $empresa->id)
                    ->where('activa', true);
            })
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $labelsMeses = [];
        $dataMeses = [];

        for ($i = 1; $i <= 12; $i++) {
            $labelsMeses[] = Carbon::create()->month($i)->translatedFormat('F');
            $dataMeses[] = $reservasPorMes->firstWhere('mes', $i)->total ?? 0;
        }

        // 🟢 Reservas por cancha (circular)
// 💰 Cobros por tipo de pago (circular)
        $cobrosPorMetodo = Cobro::where('empresa_id', $empresa->id)
            ->where('estado', 'pagado') // ajusta si usas otro estado
            ->select(
                'metodo_pago',
                DB::raw('SUM(monto) as total')
            )
            ->groupBy('metodo_pago')
            ->get();

        // 💵 Total cobrado en el mes actual
        $totalMes = Cobro::where('empresa_id', $empresa->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('monto');

        // 💵 Ventas mes anterior
        $totalMesAnterior = Cobro::where('empresa_id', $empresa->id)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('monto');

        // 📈 Variación porcentual
        if ($totalMesAnterior > 0) {
            $variacionMes = (($totalMes - $totalMesAnterior) / $totalMesAnterior) * 100;
        } else {
            $variacionMes = $totalMes > 0 ? 100 : 0;
        }

        // 💰 Ventas por mes (suma de cobros)
        $ventasPorMes = Cobro::select(
            DB::raw('MONTH(fecha_pago) as mes'),
            DB::raw('SUM(monto) as total')
        )
            ->whereYear('fecha_pago', now()->year)
            ->where('empresa_id', $empresa->id)
            ->where('estado', 'pagado')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $dataVentasMeses = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataVentasMeses[] = (float) ($ventasPorMes->firstWhere('mes', $i)->total ?? 0);
        }


        $labelsMetodoPago = $cobrosPorMetodo->pluck('metodo_pago');
        $dataMetodoPago = $cobrosPorMetodo->pluck('total');


        return view('empresadashboard.dashboard', compact(
            'empresa',
            'cantidadCanchas',
            'reservasHoy',
            'reservasMesActual',
            'variacionReservas',
            'variacionCanchas',
            'labelsMeses',
            'dataMeses',
            'totalMes',
            'variacionMes',
            'dataVentasMeses'
        ));

    }

}
