@extends('layouts.app')

@section('title', 'Tarifas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Tarifas – {{ $cancha->nombre }}</h1>

        <a href="{{ route('canchas.tarifas.create', $cancha) }}" class="btn btn-outline-success btn-sm btn-nuevo">
            + Nueva Tarifa
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">

            {{-- Buscador --}}
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control form-control-sm"
                        placeholder="Buscar por día u horario">
                </div>
            </div>

            <table id="tarifas" class="table table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Día</th>
                        <th>Horario</th>
                        <th>Precio</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($tarifas as $tarifa)
                        <tr>
                            <td>{{ $tarifa->dias_texto }}</td>

                            <td>
                                {{ substr($tarifa->hora_inicio, 0, 5) }} -
                                {{ substr($tarifa->hora_fin, 0, 5) }}
                            </td>
                            <td>S/ {{ number_format($tarifa->precio, 2) }}</td>

                            <td class="text-center">
                                <a href="{{ route('canchas.tarifas.edit', [$cancha, $tarifa]) }}"
                                    class="btn btn-sm btn-outline-warning">
                                    ✏️
                                </a>

                                <form method="POST" action="{{ route('canchas.tarifas.destroy', [$cancha, $tarifa]) }}"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteTarifaModal">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('canchas.index') }}" class="btn btn-outline-secondary btn-sm btn-nuevo">
                    ← Volver
                </a>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            let table = $('#tarifas').DataTable({
                pageLength: 5, // 👈 DE 5 EN 5
                dom: 'rtip',
                order: [], // respeta el orderBy del backend
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });

            // Buscador personalizado
            $('#buscar').on('keyup', function () {
                table.search(this.value).draw();
            });

        });
    </script>
    <script>
        let deleteForm = null;

        // Usamos delegación de eventos para que funcione con DataTables
        $(document).on('click', '.btn-delete', function () {
            deleteForm = $(this).closest('form');
        });

        $('#confirmDeleteBtn').on('click', function () {
            if (deleteForm) {
                deleteForm.submit();
            }
        });
    </script>
@endpush

<x-modal-confirm id="deleteTarifaModal" title="Eliminar tarifa"
    message="Esta acción no se puede deshacer. ¿Deseas continuar?" />