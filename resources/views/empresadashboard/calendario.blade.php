@extends('layouts.app')

@section('content')
    <div class="container">
        @if(isset($cancha))
            <h4>📅 Reservas de la cancha: {{ $cancha->nombre }}</h4>
            <br>
        @else
            <h4>📅 Resumen general de reservas</h4>
            <br>
        @endif
        <div id="calendar" style="height:700px;"></div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',   // 🔥 Vista mensual por defecto
                locale: 'es',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay' // mes | semana | día
                },

                events: @if(isset($cancha))
                    "{{ route('empresa.canchas.reservas.eventos', $cancha->id) }}"
                @else
                        "{{ route('reservas.dashboard.eventos') }}"
                    @endif,
            });

            calendar.render();
        });
    </script>

@endpush