<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    protected function username()
    {
        return 'usuario';
    }
    // Mostrar formulario
    public function showLoginForm()
    {
        return view('auth.login');
    }



    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Intentar login
        if (
            !Auth::attempt([
                'usuario' => $request->usuario,
                'password' => $request->password,
            ])
        ) {
            return back()->withErrors([
                'usuario' => 'Las credenciales no son correctas.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // 🔐 Validar que tenga rol asignado
        if (!$user->role) {
            Auth::logout();
            return back()->withErrors([
                'usuario' => 'El usuario no tiene un rol asignado.',
            ]);
        }

        // 🎯 Tomar nombre del rol desde la tabla roles
        $rol = $user->role->nombre;

        switch ($rol) {
            case 'admin':
                return redirect()->route('dashboard');

            case 'empresa':
                return redirect()->route('empresadashboard.dashboard');

            default:
                Auth::logout();
                return back()->withErrors([
                    'usuario' => 'Rol no autorizado.',
                ]);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
