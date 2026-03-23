@extends('layouts.app')

@section('title', 'Empresas')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px; margin-bottom:12px;">Empresas</h1>

        <a href="{{ route('empresas.create') }}" class="btn btn-outline-success btn-sm btn-nuevo">
            + Nueva Empresa
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">

            {{-- Buscador --}}
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control form-control-sm"
                        placeholder="Buscar por nombre de empresa, documento o representante">
                </div>
            </div>

            {{-- Tabla --}}
            <table id="empresas" class="table table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Empresa</th>
                        <th>Documento</th>
                        <th>Representante</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->nombre }}</td>
                            <td>{{ $empresa->documento }}</td>
                            <td>{{ $empresa->representante }}</td>
                            <td>{{ $empresa->telefono }}</td>
                            <td>
                                <span class="badge {{ $empresa->estado ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $empresa->estado ? 'Activo' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="text-center">

                                {{-- Editar --}}
                                <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-sm btn-outline-warning">
                                    ✏️
                                </a>

                                {{-- Eliminar --}}
                                <form method="POST" action="{{ route('empresas.destroy', $empresa) }}"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteEmpresaModal">
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

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let table = $('#empresas').DataTable({
                pageLength: 5,
                dom: 'rtip',
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });

            $('#buscar').on('keyup', function () {
                table.search(this.value).draw();
            });
        });
    </script>
    <script>
        let deleteForm = null;

        // 🔥 Delegación de eventos (compatible con DataTables)
        document.addEventListener('click', function (e) {

            // Click en botón eliminar
            if (e.target.closest('.btn-delete')) {
                deleteForm = e.target.closest('form');
            }

            // Click en confirmar del modal
            if (e.target.id === 'confirmDeleteBtn') {
                if (deleteForm) {
                    deleteForm.submit();
                }
            }
        });
    </script>
@endpush

<x-modal-confirm id="deleteEmpresaModal" title="Eliminar empresa" message="¿Desea eliminar la empresa?" />