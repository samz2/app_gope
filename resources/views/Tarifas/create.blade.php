@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Nueva tarifa – {{ $cancha->nombre }}</h4>

    <form method="POST"
          action="{{ route('canchas.tarifas.store', $cancha) }}">
        @csrf

        <div class="mb-3">
            <label>Día de la semana</label>
            <select name="dia_semana" class="form-control">
                @foreach(['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'] as $i => $dia)
                    <option value="{{ $i }}">{{ $dia }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Hora inicio</label>
            <input type="time" name="hora_inicio" class="form-control">
        </div>

        <div class="mb-3">
            <label>Hora fin</label>
            <input type="time" name="hora_fin" class="form-control">
        </div>

        <div class="mb-3">
            <label>Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control">
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('canchas.tarifas.index', $cancha) }}"
           class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
