@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h4>Editar tarifa – {{ $cancha->nombre }}</h4>

    <form method="POST"
          action="{{ route('canchas.tarifas.update', [$cancha, $tarifa]) }}">
        @csrf
        @method('PUT')

        {{-- Día --}}
        <div class="mb-3">
            <label>Día de la semana</label>
            <select name="dia_semana" class="form-control">
                @foreach(['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'] as $i => $dia)
                    <option value="{{ $i }}"
                        {{ old('dia_semana', $tarifa->dia_semana) == $i ? 'selected' : '' }}>
                        {{ $dia }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Hora inicio --}}
        <div class="mb-3">
            <label>Hora inicio</label>
            <input type="time"
                   name="hora_inicio"
                   class="form-control"
                   value="{{ old('hora_inicio', substr($tarifa->hora_inicio,0,5)) }}">
        </div>

        {{-- Hora fin --}}
        <div class="mb-3">
            <label>Hora fin</label>
            <input type="time"
                   name="hora_fin"
                   class="form-control"
                   value="{{ old('hora_fin', substr($tarifa->hora_fin,0,5)) }}">
        </div>

        {{-- Precio --}}
        <div class="mb-3">
            <label>Precio</label>
            <input type="number"
                   step="0.01"
                   name="precio"
                   class="form-control"
                   value="{{ old('precio', $tarifa->precio) }}">
        </div>

        <button class="btn btn-primary">Actualizar</button>

        <a href="{{ route('canchas.tarifas.index', $cancha) }}"
           class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
@endsection
