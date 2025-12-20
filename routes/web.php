<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
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
