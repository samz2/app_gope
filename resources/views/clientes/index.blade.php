@extends('layouts.dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-success">
            Nuevo Cliente
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control" placeholder="Buscar por nombre o teléfono">
                </div>
            </div>
            <table id="clientes" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombres }}</td>
                            <td>{{ $cliente->apellidos }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->latitud }}</td>
                            <td>{{ $cliente->longitud }}</td>
                            <td>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                let table = $('#clientes').DataTable({
                    pageLength: 5,
                    dom: 'rtip', // oculta buscador nativo
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                    }
                });

                $('#buscar').on('keyup', function () {
                    table.search(this.value).draw();
                });
            });
        </script>
    @endpush

@endsection