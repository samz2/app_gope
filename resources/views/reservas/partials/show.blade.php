@extends('layouts.app')

@section('title', 'Detalle de Reserva')

@section('content')
    <div class="container">

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">📄 Detalle de la Reserva</h5>
            </div>

            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $reserva->cliente->nombres }}</p>
                <p><strong>Cancha:</strong> {{ $reserva->cancha->nombre }}</p>
                <p><strong>Fecha:</strong> {{ $reserva->fecha }}</p>
                <p><strong>Horario:</strong>
                    {{ substr($reserva->hora_inicio, 0, 5) }} -
                    {{ substr($reserva->hora_fin, 0, 5) }}
                </p>
                <p><strong>Precio:</strong> S/ {{ number_format($reserva->precio, 2) }}</p>
                <p><strong>Estado:</strong>
                    <span class="badge bg-{{ $reserva->pagado ? 'success' : 'warning' }}">
                        {{ $reserva->pagado ? 'Pagado' : 'Pendiente' }}
                    </span>
                </p>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('reservas.index') }}" class="btn btn-secondary">
                    ⬅ Volver
                </a>
            </div>
        </div>

    </div>
@endsection