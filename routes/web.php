<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\ClienteController;

use App\Models\Empresa;
use App\Models\Cliente;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard', [
        'empresas' => Empresa::count(),
        'clientes' => Cliente::count()
    ]);
});

// Módulo Empresas
Route::resource('empresas', EmpresaController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('canchas', CanchaController::class);
Route::resource('canchas.tarifas', TarifaController::class);

// Módulo Provincias y Distritos
Route::get('/provincias/{region}', [UbicacionController::class, 'provincias']);
Route::get('/distritos/{provincia}', [UbicacionController::class, 'distritos']);
