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
use App\Http\Controllers\EmpresaDashboardController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\CanchaImagenController;
use App\Http\Controllers\CobroController;



/*
|--------------------------------------------------------------------------
| Dashboard principal (ADMIN)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


// Módulo Empresas
Route::resource('empresas', EmpresaController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('canchas', CanchaController::class);
Route::resource('canchas.tarifas', TarifaController::class);
Route::resource('tarifas', TarifaController::class);
Route::resource('canchas.tarifas', TarifaController::class);

Route::delete(
    '/canchas/imagenes/{imagen}',
    [CanchaImagenController::class, 'destroy']
)->name('canchas.imagenes.destroy');

// Módulo Provincias y Distritos
Route::get('/provincias/{region}', [UbicacionController::class, 'provincias']);
Route::get('/distritos/{provincia}', [UbicacionController::class, 'distritos']);

// Login-Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Empresa
Route::middleware(['auth'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/dashboard', [EmpresaController::class, 'dashboard'])
        ->name('dashboard');
});

// Módulo Clientes
Route::get('/clientes/datatable', [ClienteController::class, 'datatable'])
    ->name('clientes.datatable');

// User

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin']) // agrega aquí tu middleware de permisos si usas roles
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
| Dashboard principal (EMPRESA)
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'role:empresa'])
    ->prefix('empresadashboard')
    ->name('empresadashboard.')
    ->group(function () {

        Route::get('/dashboard', [EmpresaDashboardController::class, 'index'])
            ->name('dashboard');


    });

Route::resource('reservas', ReservaController::class)->except(['show']);

Route::get(
    '/empresa/canchas/{cancha}/reservas',
    [ReservaController::class, 'calendarioPorCancha']
)->name('empresa.canchas.reservas.calendario');

Route::get(
    '/empresa/canchas/{cancha}/reservas/eventos',
    [App\Http\Controllers\ReservaController::class, 'eventosPorCancha']
)->name('empresa.canchas.reservas.eventos');

// Calendario resumen en dashboard empresa
Route::get(
    '/empresa/dashboard/calendario',
    [App\Http\Controllers\ReservaController::class, 'calendarioDashboard']
)->name('reservas.dashboard.calendario');

Route::get(
    '/empresa/dashboard/calendario/eventos',
    [App\Http\Controllers\ReservaController::class, 'eventosDashboard']
)->name('reservas.dashboard.eventos');

// Detalle por día
Route::get(
    '/empresa/dashboard/reservas/{fecha}',
    [App\Http\Controllers\ReservaController::class, 'detallePorDia']
)->name('reservas.dashboard.detalle');


Route::get('/tarifas/precio', [App\Http\Controllers\TarifaController::class, 'buscarPrecio'])
    ->name('tarifas.buscarPrecio');

Route::get(
    '/reservas/verificar-disponibilidad',
    [App\Http\Controllers\ReservaController::class, 'verificarDisponibilidad']
)->name('reservas.verificarDisponibilidad');

Route::get('/reservas/buscar-precio', [ReservaController::class, 'buscarPrecio'])
    ->name('reservas.buscarPrecio');


Route::post('/notificaciones/leidas', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notificaciones.leer');


Route::patch('canchas/{cancha}/toggle', [CanchaController::class, 'toggle'])
    ->name('canchas.toggle');



Route::middleware(['auth'])->group(function () {

    Route::get('cobros', [CobroController::class, 'index'])
        ->name('cobros.index');

    // (opcional, lo activamos cuando quieras)
    Route::patch('cobros/{cobro}/pagado', [CobroController::class, 'marcarPagado'])
        ->name('cobros.pagado');
});
Route::get('/reservas/{reserva}', [ReservaController::class, 'show'])
    ->name('reservas.partials.show');

Route::put('/reservas/{reserva}/pagar', [ReservaController::class, 'pagar'])
    ->name('reservas.pagar');

Route::post('/notifications/{id}/read', function ($id) {

    $notification = auth()->user()
        ->notifications()
        ->where('id', $id)
        ->firstOrFail();

    // Marcar como leída
    $notification->markAsRead();

    // URL segura (nueva o vieja)
    $url = $notification->data['url']
        ?? route('reservas.partials.show', $notification->data['reserva_id']);

    return redirect()->to($url);

})->name('notifications.read');

