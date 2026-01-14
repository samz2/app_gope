<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioCreadoMail;


class UserController extends Controller
{
    /**
     * Mostrar listado de usuarios
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        $users = User::with('role')
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('name', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.usuarios.index', compact('users', 'buscar'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $roles = Role::orderBy('nombre')->get();
        $user = null; // 👈 clave


        return view('admin.usuarios.create', compact('roles', 'user'));
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $plainPassword = $request->password;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role_id' => $request->role_id,
        ]);

        // 📧 Enviar correo
        \Mail::to($user->email)->send(
            new UsuarioCreadoMail($user, $plainPassword)
        );

        return redirect()
            ->route('admin.usuarios.index')
            ->with('modal_success', [
                'title' => 'Usuario creado',
                'message' => 'El usuario fue registrado correctamente.',
                'redirect' => route('admin.usuarios.index'),
            ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('nombre')->get();

        return view('admin.usuarios.edit', compact('user', 'roles'));
    }



    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
        ]);


        $data = $request->only(['name', 'email', 'role_id']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('modal_success', [
                'title' => 'Usuario actualizado',
                'message' => 'Los datos del usuario se actualizaron correctamente.',
                'redirect' => route('admin.usuarios.index'),
            ]);
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        // eliminación real (usuarios no suelen manejar estado)
        $user->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('modal_success', [
                'title' => 'Usuario eliminado',
                'message' => 'El usuario fue eliminado correctamente.',
                'redirect' => route('admin.usuarios.index'),
            ]);
    }


}
