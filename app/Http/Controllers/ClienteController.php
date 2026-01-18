<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
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
        $departamentos = Departamento::orderBy('nombre')->get();
        $provincias = collect(); // vacío al inicio
        $distritos = collect();

        return view('clientes.create', compact(
            'departamentos',
            'provincias',
            'distritos'
        ));
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
            'distrito_id' => 'required|exists:distritos,id',

        ]);

        $cliente = Cliente::create($request->only([
            'nombres',
            'apellidos',
            'telefono',
            'email',
            'latitud',
            'longitud',
            'estado',
            'distrito_id',
        ]));


        return redirect()
            ->route('clientes.index')
            ->with('modal_success', [
                'title' => 'Cliente creado',
                'message' => 'El cliente fue registrado correctamente.',
                'redirect' => route('clientes.index'),
            ]);


    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $cliente = Cliente::where('id', $id)->firstOrFail();
        $departamentos = Departamento::orderBy('nombre')->get();

        $distrito = Distrito::with('provincia.departamento')
            ->findOrFail($cliente->distrito_id);

        $provincia = $distrito->provincia;
        $departamento = $provincia->departamento;

        $provincias = Provincia::where('departamento_id', $departamento->id)->get();
        $distritos = Distrito::where('provincia_id', $provincia->id)->get();

        return view('clientes.edit', compact(
            'cliente',
            'departamentos',
            'provincias',
            'distritos',
            'departamento',
            'provincia',
            'distrito'
        ));
    }

    /**
     * Actualizar cliente
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::where('id', $id)->firstOrFail();
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
            ->with('modal_success', [
                'title' => 'Cliente actualizado',
                'message' => 'Los datos del cliente se actualizaron correctamente.',
                'redirect' => route('clientes.index'),
            ]);
    }

    /**
     * Eliminar cliente (soft lógico)
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->update(['estado' => 'inactivo']);


        return redirect()
            ->route('clientes.index')
            ->with('modal_success', [
                'title' => 'Cliente eliminado',
                'message' => 'El cliente fue eliminado correctamente.',
                'redirect' => route('clientes.index'),
            ]);
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
