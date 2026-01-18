<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\TarifaController;
use App\Models\Empresa;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard', [
        'empresas' => Empresa::count()
    ]);
});
Route::resource('empresas', EmpresaController::class);
Route::resource('canchas', CanchaController::class);
Route::resource('canchas.tarifas', TarifaController::class);

Route::get('/provincias/{region}', [UbicacionController::class, 'provincias']);
Route::get('/distritos/{provincia}', [UbicacionController::class, 'distritos']);

