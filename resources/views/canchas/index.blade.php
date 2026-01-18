@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Canchas</h1>

    <a href="{{ route('canchas.create') }}" class="btn btn-primary">
        + Nueva Cancha
    </a>
</div>
<div class="card">
    <div class="card-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($canchas as $cancha)
            <tr>
                <td>{{ $cancha->empresa->nombre }}</td>
                <td>{{ $cancha->nombre }}</td>
                <td>{{ ucwords($cancha->tipo) }} </td>
                <td>
                    <span class="badge bg-{{ $cancha->activa ? 'success' : 'secondary' }}">
                        {{ $cancha->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('canchas.tarifas.index', $cancha) }}"
                    class="btn btn-sm btn-info"
                    title="Configurar tarifas">
                        ⏱️
                    </a>
                    <a href="{{ route('canchas.edit', $cancha) }}"
                    class="btn btn-sm btn-warning">
                        ✏️
                    </a>

                    <form action="{{ route('canchas.destroy', $cancha) }}"
                        method="POST"
                        style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar cancha?')">
                            🗑️
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
{{ $canchas->links() }}
@endsection
