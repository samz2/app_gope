@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Reservas</h1>

        <a href="{{ route('reservas.create') }}" class="btn btn-outline-success btn-sm btn-nuevo">
            + Nueva Reserva
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">

            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control form-control-sm"
                        placeholder="Buscar cliente o cancha">
                </div>
            </div>

            <table id="reservas" class="table table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        @if(auth()->user()->role->nombre === 'admin')
                            <th>Empresa</th>
                        @endif
                        <th>Cliente</th>
                        <th>Cancha</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Precio</th>
                        <!--<th>Estado</th>-->
                        <th class="text-center">Estado Pago</th>
                        <th class="text-center" style="width: 140px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reservas as $reserva)
                        <tr>
                            @if(auth()->user()->role->nombre === 'admin')
                                <td>{{ $reserva->empresa->nombre }}</td>
                            @endif
                            <td>{{ $reserva->cliente->nombres }} {{ $reserva->cliente->apellidos }}</td>
                            <td>{{ $reserva->cancha->nombre }}</td>
                            <td>{{ $reserva->fecha }}</td>
                            <td>{{ substr($reserva->hora_inicio, 0, 5) }} - {{ substr($reserva->hora_fin, 0, 5) }}</td>
                            <td>S/ {{ number_format($reserva->precio, 2) }}</td>
                            <!--<td>{{ ucfirst($reserva->estado) }}</td> -->
                            <td class="text-center">
                                @if($reserva->pagado)
                                    <span class="badge bg-success">Pagado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @endif

                            </td>

                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">

                                    @if(!$reserva->pagado)
                                        <button class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#pagoModal{{ $reserva->id }}" title="Cobrar">
                                            💵
                                        </button>
                                    @endif

                                    <a href="{{ route('reservas.edit', $reserva) }}" class="btn btn-outline-warning"
                                        title="Editar">
                                        ✏️
                                    </a>

                                </div>
                            </td>

                        </tr>
                        @include('reservas.partials.modal-pago')

                    @endforeach


                </tbody>
            </table>

            {{ $reservas->links() }}

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('submit', '.delete-form', function (e) {
            e.preventDefault();

            let form = this;

            Swal.fire({
                title: '¿Eliminar reserva?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            let table = $('#reservas').DataTable({
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
@endpush