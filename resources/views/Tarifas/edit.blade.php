@extends('layouts.app')

@section('title', 'Editar Tarifa')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Editar Tarifa – {{ $cancha->nombre }}</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('canchas.tarifas.update', [$cancha, $tarifa]) }}">
                @csrf
                @method('PUT')

                {{-- Día de la semana --}}
                <div class="mb-3">
                    <label class="form-label">Días de la semana</label>

                    <div class="d-flex flex-wrap gap-3">
                        @foreach(['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $i => $dia)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dia_semana[]" value="{{ $i }}"
                                    id="dia{{ $i }}" {{ in_array($i, old('dia_semana', $tarifa->dia_semana)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="dia{{ $i }}">
                                    {{ $dia }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                {{-- Hora inicio --}}
                <div class="mb-3">
                    <label class="form-label">Hora inicio</label>
                    <input type="time" name="hora_inicio" class="form-control form-control-sm"
                        value="{{ old('hora_inicio', substr($tarifa->hora_inicio, 0, 5)) }}" required>
                </div>

                {{-- Hora fin --}}
                <div class="mb-3">
                    <label class="form-label">Hora fin</label>
                    <input type="time" name="hora_fin" class="form-control form-control-sm"
                        value="{{ old('hora_fin', substr($tarifa->hora_fin, 0, 5)) }}" required>
                </div>

                {{-- Precio --}}
                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control form-control-sm"
                        value="{{ old('precio', $tarifa->precio) }}" required>
                </div>

                {{-- Botones (idénticos a clientes / canchas) --}}
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('canchas.tarifas.index', $cancha) }}" class="btn btn-outline-danger btn-sm btn-nuevo">
                        Cancelar
                    </a>
                    <button class="btn btn-success btn-sm btn-nuevo">
                        Actualizar Tarifa
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection