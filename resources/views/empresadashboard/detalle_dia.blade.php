@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>⏰ Reservas del día {{ $fecha }}</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cancha</th>
                    <th>Cliente</th>
                    <th>Hora inicio</th>
                    <th>Hora fin</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->cancha->nombre }}</td>
                        <td>{{ $reserva->cliente->nombres }}</td>
                        <td>{{ $reserva->hora_inicio }}</td>
                        <td>{{ $reserva->hora_fin }}</td>
                        <td>{{ $reserva->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('reservas.dashboard.calendario') }}" class="btn btn-secondary">
            ⬅ Volver al calendario
        </a>
    </div>
@endsection