@extends('layouts.app')

@section('title', 'Cobros')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px; margin-bottom:12px;">Cobros</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">

            {{-- Buscador --}}
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="buscar" class="form-control form-control-sm"
                        placeholder="Buscar por cliente o cancha">
                </div>
            </div>

            <table id="cobros" class="table table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Cliente</th>
                        <th>Cancha</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cobros as $cobro)
                        <tr>
                            <td>{{ $cobro->reserva->cliente->nombres ?? '-' }}</td>
                            <td>{{ $cobro->reserva->cancha->nombre ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($cobro->fecha_pago)->format('d/m/Y') }}</td>
                            <td>S/ {{ number_format($cobro->monto, 2) }}</td>
                            <td>{{ ucfirst($cobro->metodo_pago) }}</td>
                            <td>
                                <span class="badge bg-success">Pagado</span>
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

            let table = $('#cobros').DataTable({
                pageLength: 5,
                dom: 'rtip',
                order: [[2, 'desc']], // ordenar por fecha
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