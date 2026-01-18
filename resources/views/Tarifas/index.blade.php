@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Tarifas – {{ $cancha->nombre }}</h4>

    <a href="{{ route('canchas.tarifas.create', $cancha) }}"
       class="btn btn-primary mb-3">
        + Nueva Tarifa
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Día</th>
                <th>Horario</th>
                <th>Precio</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($tarifas as $tarifa)
            <tr>
                <td>
                    {{ ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'][$tarifa->dia_semana] }}
                </td>
                <td>
                    {{ substr($tarifa->hora_inicio,0,5) }}
                    -
                    {{ substr($tarifa->hora_fin,0,5) }}
                </td>
                <td>S/ {{ number_format($tarifa->precio, 2) }}</td>
                <td>
                    <a href="{{ route('canchas.tarifas.edit', [$cancha, $tarifa]) }}"
                       class="btn btn-sm btn-warning">✏️</a>

                    <form action="{{ route('canchas.tarifas.destroy', [$cancha, $tarifa]) }}"
                          method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
