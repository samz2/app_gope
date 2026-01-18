@extends('layouts.app')

@section('title', 'Clientes')
@php
    $clienteGuardado = session()->has('cliente_guardado');
@endphp


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px; margin-bottom:12px;">Clientes</h1>

        <a href="{{ route('clientes.create') }}" class="btn btn-outline-success btn-sm btn-nuevo">
            + Nuevo Cliente
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control form-control-sm"
                        placeholder="Buscar por nombre o teléfono">
                </div>
            </div>

            <table id="clientes" class="table table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Lat</th>
                        <th>Lng</th>
                        <th class="text-center">Acciones</th>
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
                            <td class="text-center">
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-warning">
                                    ✏️
                                </a>

                                <form method="POST"
                                    action="{{ route('clientes.destroy', $cliente) }}"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteClienteModal">
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

@if($clienteGuardado)
<div class="modal fade show" id="clienteModal" tabindex="-1" style="display:block;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header border-0 justify-content-center">
                <div class="text-center">
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    <h5 class="mt-2 mb-0">Cliente guardado</h5>
                </div>
            </div>

            <div class="modal-body text-center">
                <p class="text-muted mb-0">
                    El cliente se registró correctamente.
                </p>
            </div>

            <div class="modal-footer border-0 justify-content-center gap-2">
                <a href="{{ route('clientes.index') }}" class="btn btn-success px-4">
                    OK
                </a>
            </div>

        </div>
    </div>
</div>

<div class="modal-backdrop fade show"></div>
@endif


@push('scripts')
    <script>
        $(document).ready(function () {
            let table = $('#clientes').DataTable({
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

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            deleteForm = this.closest('form');
        });
    }); 

    document.getElementById('confirmDeleteBtn')
        .addEventListener('click', function () {
            if (deleteForm) {
                deleteForm.submit();
            }
        });
</script>

@endpush

<x-modal-success />

<x-modal-confirm
    id="deleteClienteModal"
    title="Eliminar cliente"
    message="Esta acción no se puede deshacer. ¿Deseas continuar?"
/>