<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Cancha;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $empresas = Empresa::activos()->count();
        $clientes = Cliente::activos()->count();
        $usuarios = User::count();
        $canchas = Cancha::count();

        $empresasPorMes = Empresa::activos()
            ->select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $clientesPorMes = Cliente::activos()
            ->select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('dashboard.index', compact(
            'empresas',
            'clientes',
            'usuarios',
            'canchas',
            'empresasPorMes',
            'clientesPorMes'
        ));
    }
}
