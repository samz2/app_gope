<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;


//Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


// Módulo Empresas
Route::resource('empresas', EmpresaController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('canchas', CanchaController::class);
Route::resource('canchas.tarifas', TarifaController::class);

// Módulo Provincias y Distritos
Route::get('/provincias/{region}', [UbicacionController::class, 'provincias']);
Route::get('/distritos/{provincia}', [UbicacionController::class, 'distritos']);

// Módulo Clientes
Route::resource('clientes', ClienteController::class);
Route::get('/clientes/datatable', [ClienteController::class, 'datatable'])
    ->name('clientes.datatable');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas protegidas por login y rol
|--------------------------------------------------------------------------
*/

// User

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth']) // agrega aquí tu middleware de permisos si usas roles
    ->group(function () {

        Route::get('usuarios', [UserController::class, 'index'])
            ->name('usuarios.index');

        Route::get('usuarios/create', [UserController::class, 'create'])
            ->name('usuarios.create');

        Route::post('usuarios', [UserController::class, 'store'])
            ->name('usuarios.store');

        Route::get('usuarios/{user}/edit', [UserController::class, 'edit'])
            ->name('usuarios.edit');

        Route::put('usuarios/{user}', [UserController::class, 'update'])
            ->name('usuarios.update');

        Route::delete('usuarios/{user}', [UserController::class, 'destroy'])
            ->name('usuarios.destroy');
    });

// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/password', [ProfileController::class, 'password'])->name('perfil.password');
});


/*
|--------------------------------------------------------------------------
| Rutas para EMPRESA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('empresa')->name('empresa.')->group(function () {

    Route::get('/dashboard', [EmpresaController::class, 'dashboard'])
        ->name('dashboard');

});
