<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class ClienteController extends Controller
{
    /**
     * Mostrar listado de clientes
     */
    public function index(Request $request)
    {
        /**$clientes = Cliente::orderBy('id', 'desc')->get();

        return view('clientes.index', compact('clientes'));*/

        $buscar = $request->get('buscar');

        $clientes = Cliente::where('estado', 'activo') // 👈 SOLO ACTIVOS
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombres', 'like', "%{$buscar}%")
                        ->orWhere('apellidos', 'like', "%{$buscar}%")
                        ->orWhere('telefono', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('clientes.index', compact('clientes', 'buscar'));
    }



    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guardar nuevo cliente
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Cliente::create($request->all());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar cliente
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $cliente->update($request->all());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Eliminar cliente (soft lógico)
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->update(['estado' => 'inactivo']);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
    public function buscarAjax(Request $request)
    {
        $buscar = $request->get('q');

        $clientes = Cliente::where('nombres', 'like', "%{$buscar}%")
            ->orWhere('apellidos', 'like', "%{$buscar}%")
            ->orWhere('telefono', 'like', "%{$buscar}%")
            ->limit(10)
            ->get();

        return response()->json($clientes);
    }

    public function datatable()
    {
        $clientes = Cliente::where('estado', 'activo');

        return DataTables::of($clientes)
            ->addColumn('acciones', function ($cliente) {
                return '
                <a href="/clientes/' . $cliente->id . '/edit" class="btn btn-sm btn-primary">Editar</a>

                <form action="/clientes/' . $cliente->id . '" method="POST" style="display:inline"
                    onsubmit="return confirm(\'¿Eliminar cliente?\')">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            ';
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

}
