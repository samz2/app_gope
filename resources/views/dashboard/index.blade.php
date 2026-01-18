@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<br>
    <h2 class="dashboard-title"align="center">BIENVENIDO A TU SISTEMA</h2>
<br>
    <div class="stats">
        <a href="{{ route('empresas.index') }}" class="card-link">
            <div class="stat-card green">
                <div class="stat-content">
                    <span>Empresas</span>
                    <h2>{{ $empresas }}</h2>
                </div>
                <div class="stat-icon">
                    🏢
                </div>
            </div>
        </a>

        <a href="{{ route('clientes.index') }}" class="card-link">
            <div class="stat-card blue">
                <div class="stat-content">
                    <span>Clientes</span>
                    <h2>{{ $clientes }}</h2>
                </div>
                <div class="stat-icon">
                    👥
                </div>
            </div>
        </a>

        <a href="{{ route('admin.usuarios.index') }}" class="card-link">
            <div class="stat-card purple">
                <div class="stat-content">
                    <span>Usuarios</span>
                    <h2>{{ $usuarios }}</h2>
                </div>
                <div class="stat-icon">
                    👤
                </div>
            </div>
            </a>

                    <a href="{{ route('canchas.index') }}" class="card-link">
            <div class="stat-card purple">
                <div class="stat-content">
                    <span>Canchas</span>
                    <h2>{{ $canchas }}</h2>
                </div>
                <div class="stat-icon">
                    🏃
                </div>
            </div>
            </a>
    </div>

<div class="charts">
    {{-- Gráfico de barras --}}
    <div class="chart-card">
        <div class="chart-header">
            <h3>Resultados</h3>
        </div>

        <div class="chart-body">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    {{-- Gráfico circular --}}
    <div class="chart-card">
        <div class="chart-header">
            <h3>Comisiones</h3>
        </div>

        <div class="chart-body">
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('barChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.35)'); // violeta suave
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.05)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Empresas', 'Clientes', 'Usuarios'],
            datasets: [{
                label: 'Totales',
                data: [
                    {{ $empresas }},
                    {{ $clientes }},
                    {{ $usuarios }}
                ],
                borderColor: '#6366f1',   // línea principal
                backgroundColor: gradient,
                fill: true,               // 👈 área
                tension: 0.45,            // 👈 curva suave
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#fff',
                    bodyColor: '#e5e7eb',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>



    <script>
        /* ====== GRÁFICO CIRCULAR – COMISIONES ====== */
        const pieCtx = document.getElementById('pieChart');

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Transferencias', 'Pagos', 'Suscripciones'],
                datasets: [{
                    data: [1200, 800, 500], // 🔒 valores en duro por ahora
                    backgroundColor: [
                        '#22c55e', // verde
                        '#3b82f6', // azul
                        '#a855f7'  // morado
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            boxWidth: 14
                        }
                    }
                }
            }
        });
    </script>
@endpush