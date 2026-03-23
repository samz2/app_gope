@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Reservas de la cancha: {{ $cancha->nombre }}</h2>

        <div id="calendar"></div>
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
                initialView: 'dayGridMonth',
                locale: 'es',
                events: '{{ route("empresa.canchas.reservas.eventos", $cancha->id) }}'
            });

            calendar.render();
        });
    </script>
@endpush