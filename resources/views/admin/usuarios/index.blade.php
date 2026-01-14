@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px; margin-bottom:12px;">Usuarios</h1>

        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-outline-success btn-sm btn-nuevo">
            + Nuevo Usuario
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">

            {{-- Buscador --}}
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control form-control-sm"
                        placeholder="Buscar por nombre, email o rol">
                </div>
            </div>

            <table id="usuarios" class="table table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->nombre ?? '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.usuarios.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                    ✏️
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.usuarios.destroy', $user) }}"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal">
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
            let table = $('#usuarios').DataTable({
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

        // Cuando se hace click en 🗑️
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                deleteForm = this.closest('form');
            });
        });

        // Cuando se confirma en el modal
        document.getElementById('confirmDeleteBtn')
            .addEventListener('click', function () {
                if (deleteForm) {
                    deleteForm.submit();
                }
            });
    </script>

@endpush

<x-modal-success />

<x-modal-confirm id="deleteUserModal" title="Eliminar usuario"
    message="Esta acción no se puede deshacer. ¿Deseas continuar?" />