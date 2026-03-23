<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Empresa;
use App\Mail\UsuarioCreadoMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



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
        $empresas = Empresa::orderBy('nombre')->get();


        return view('admin.usuarios.create', compact('roles', 'user', 'empresas'));
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:users,usuario',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'empresa_id' => 'nullable|exists:empresas,id',
        ]);

        $plainPassword = $request->password;

        $user = User::create([
            'name' => $request->name,
            'usuario' => $request->usuario,
            'password' => Hash::make($plainPassword),
            'role_id' => $request->role_id,
            'empresa_id' => $request->empresa_id,
        ]);


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
        $empresas = Empresa::orderBy('nombre')->get();

        return view('admin.usuarios.edit', compact('user', 'roles', 'empresas'));
    }



    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:users,usuario,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
            'empresa_id' => 'nullable|exists:empresas,id',
        ]);


        $data = $request->only(['name', 'usuario', 'role_id', 'empresa_id']);

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
