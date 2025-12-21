<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::paginate(10);
        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Empresa::create(
            $request->except('_token')
        );

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa creada correctamente');
    }
    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $empresa->update(
            $request->except('_token')
        );

        return redirect()->route('empresas.index')
                        ->with('success', 'Empresa actualizada');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa eliminada correctamente');
    }
}
