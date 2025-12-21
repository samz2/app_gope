@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Empresas</h1>

    <a href="{{ route('empresas.create') }}" class="btn btn-primary">
        + Nueva Empresa
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Representante</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->id }}</td>
                        <td>{{ $empresa->nombre }}</td>
                        <td>{{ $empresa->documento }}</td>
                        <td>{{ $empresa->representante }}</td>
                        <td>{{ $empresa->direccion }}</td>
                        <td>{{ $empresa->telefono }}</td>
                        <td>{{ $empresa->estado }}</td>
                        
                        <td>
                            <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('empresas.destroy', $empresa) }}"
                                  method="POST"
                                  style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination mt-3">
            {{ $empresas->links() }}
        </div>
    </div>
</div>
@endsection
