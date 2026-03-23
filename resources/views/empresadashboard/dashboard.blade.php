@extends('layouts.app')

@section('title', 'Panel de Empresa')

@section('content')

    <br>
    <div class="d-flex justify-content-center align-items-center gap-4">
        <h2 class="dashboard-title mb-0">
            BIENVENIDO A TU SISTEMA
        </h2>
        <br>
    </div>
    <br>

    <div class="stats">

        {{-- Ventas del mes --}}
        <a href="{{ route('cobros.index') }}" class="card-link">

            <div class="stat-card blue">
                <div class="stat-content">
                    <span>Ventas del mes de </span>
                    <small class="text-muted">
                        {{ now()->translatedFormat('F Y') }}
                    </small>

                    <h2>S/ {{ number_format($totalMes, 2) }}</h2>

                    @if($variacionMes > 0)
                        <small class="text-success">
                            ▲ {{ number_format($variacionMes, 1) }}% vs mes anterior
                        </small>
                    @elseif($variacionMes < 0)
                        <small class="text-danger">
                            ▼ {{ number_format(abs($variacionMes), 1) }}% vs mes anterior
                        </small>
                    @else
                        <small class="text-muted">
                            Sin variación
                        </small>
                    @endif
                </div>

                <div class="stat-icon">💰</div>
            </div>

        </a>

        {{-- Reservas del mes --}}
        <a href="{{ route('reservas.index') }}" class="card-link">
            <div class="stat-card green">
                <div class="stat-content">
                    <span>Reservas del mes</span>

                    <h2>{{ $reservasMesActual }}</h2>

                    @if($variacionReservas > 0)
                        <small class="text-success">
                            ▲ {{ number_format($variacionReservas, 1) }}% vs mes anterior
                        </small>
                    @elseif($variacionReservas < 0)
                        <small class="text-danger">
                            ▼ {{ number_format(abs($variacionReservas), 1) }}% vs mes anterior
                        </small>
                    @else
                        <small class="text-muted">
                            Sin variación
                        </small>
                    @endif
                </div>

                <div class="stat-icon">📅</div>
            </div>
        </a>



        {{-- Mis Canchas --}}
        <a href="{{ route('canchas.index') }}" class="card-link">
            <div class="stat-card purple">
                <div class="stat-content">
                    <span>Mis Canchas</span>
                    <h2>{{ $cantidadCanchas }}</h2>
                </div>
                <div class="stat-icon"> 🏆</div>
            </div>
        </a>



    </div>

    <div class="charts mt-4">
        {{-- Gráfico barras --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3>Ventas y Reservas del ({{ now()->year }})</h3>
            </div>
            <div class="chart-body">
                <canvas id="reservasMesChart"></canvas>
            </div>
        </div>

        {{-- Gráfico ventas por mes --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3>Comisión del ({{ now()->year }})</h3>
            </div>
            <div class="chart-body">
                <canvas id="ventasMesChart"></canvas>
            </div>
        </div>

    </div>


@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('reservasMesChart').getContext('2d');

        const gradientReservas = ctx.createLinearGradient(0, 0, 0, 250);
        gradientReservas.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
        gradientReservas.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

        const gradientVentas = ctx.createLinearGradient(0, 0, 0, 250);
        gradientVentas.addColorStop(0, 'rgba(34, 197, 94, 0.35)');
        gradientVentas.addColorStop(1, 'rgba(34, 197, 94, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labelsMeses),
                datasets: [
                    {
                        label: 'Reservas',
                        data: @json($dataMeses),
                        borderColor: '#3b82f6',
                        backgroundColor: gradientReservas,
                        fill: true,
                        tension: 0.45,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Ventas (S/)',
                        data: @json($dataVentasMeses),
                        borderColor: '#22c55e',
                        backgroundColor: gradientVentas,
                        fill: true,
                        tension: 0.45,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                if (context.dataset.label.includes('Ventas')) {
                                    return 'S/ ' + Number(context.raw).toFixed(2);
                                }
                                return context.raw + ' reservas';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush