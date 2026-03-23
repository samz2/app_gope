@extends('layouts.app')

@section('title', 'Canchas')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px; margin-bottom:12px;">
            {{ auth()->user()->role->nombre === 'admin' ? 'Canchas' : 'Mis Canchas' }}
        </h1>

        <a href="{{ route('canchas.create') }}" class="btn btn-outline-success btn-sm btn-nuevo">
            + Nueva Cancha
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">

            {{-- Buscador --}}
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control form-control-sm"
                        placeholder="Buscar por nombre o tipo">
                </div>
            </div>
            @if(session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif
            <table id="canchas" class="table table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        {{-- Empresa solo para admin --}}
                        @if(auth()->user()->role->nombre === 'admin')
                            <th>Empresa</th>
                        @endif
                        <th>Nombre de la cancha</th>
                        <th>Tipo</th>
                        <th>Imagen</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($canchas as $cancha)
                        <tr>
                            @if(auth()->user()->role->nombre === 'admin')
                                <td>{{ $cancha->empresa->nombre }}</td>
                            @endif
                            <td>{{ $cancha->nombre }}</td>
                            <td>{{ ucwords($cancha->tipo) }}</td>

                            <td>
                                @if($cancha->imagenPrincipal)
                                    <img src="{{ asset('storage/' . $cancha->imagenPrincipal->ruta) }}" class="rounded"
                                        style="width:70px;height:50px;object-fit:cover;">
                                @else
                                    <span class="text-muted small">Sin imagen</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input toggle-cancha"
                                           type="checkbox"
                                               data-id="{{ $cancha->id }}"
                                           {{ $cancha->activa ? 'checked' : '' }}>
                                </div>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('empresa.canchas.reservas.calendario', $cancha->id) }}"
                                    class="btn btn-sm btn-outline-success btn-nuevo" title="Ver reservas">
                                    📅
                                </a>
                                <a href="{{ route('canchas.tarifas.index', $cancha) }}"
                                    class="btn btn-sm btn-outline-reloj btn-reloj" title="Configurar tarifas">
                                    ⏱️
                                </a>
                                <a href="{{ route('canchas.edit', $cancha) }}" class="btn btn-sm btn-outline-warning"
                                    title="Editar">
                                    ✏️
                                </a>

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
            let table = $('#canchas').DataTable({
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
document.querySelectorAll('.toggle-cancha').forEach(toggle => {
    toggle.addEventListener('change', function () {

        const canchaId = this.dataset.id;

        fetch(`/canchas/${canchaId}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message);
                this.checked = !this.checked; // rollback
            }
        })
        .catch(() => {
            alert('Error al actualizar estado');
            this.checked = !this.checked;
        });
    });
});
</script>

@endpush

<x-modal-confirm id="deleteCanchaModal" title="Eliminar cancha"
    message="Esta acción no se puede deshacer. ¿Deseas continuar?" />