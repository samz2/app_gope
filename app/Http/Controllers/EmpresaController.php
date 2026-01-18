<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Models\Provincia;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $query = Empresa::with('distrito.provincia.departamento');

        // if ($request->filled('search')) {
        //     $query->search($request->search);
        // }
        
        $empresas = $query->paginate(10)->withQueryString();
        if ($request->ajax()) {
            return view('empresas.partials.table', compact('empresas'))->render();
        }

        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresas.create', [
            'departamentos' => Departamento::get(),
        ]);
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
        $distrito  = $empresa->distrito;
        $provincia = optional($distrito)->provincia;
        $region    = optional($provincia)->departamento;

        return view('empresas.edit', [
            'empresa' => $empresa,
            'departamentos' => Departamento::all(),
            'provincias' => $region
                ? $region->provincias
                : collect(),
            'distritos' => $provincia
                ? $provincia->distritos
                : collect(),

            'departamentoSeleccionado' => optional($region)->id,
            'provinciaSeleccionada' => optional($provincia)->id,
            'distritoSeleccionado' => optional($distrito)->id,
        ]);
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
