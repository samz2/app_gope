@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Tarifa</h2>

        <form action="{{ route('canchas.tarifas.store', $cancha) }}" method="POST">
            @csrf

            {{-- Cancha --}}
            <div class="mb-3">
                <label class="form-label">Cancha</label>
                <input type="text" class="form-control" value="{{ $cancha->nombre }}" disabled>
            </div>

            {{-- Días --}}
            <div class="mb-3">
                <label class="form-label">Días de la semana</label>
                <div class="d-flex flex-wrap gap-3">

                    @foreach(['0' => 'Dom', '1' => 'Lun', '2' => 'Mar', '3' => 'Mié', '4' => 'Jue', '5' => 'Vie', '6' => 'Sáb'] as $num => $dia)
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input me-1" name="dia_semana[]" value="{{ $num }}">
                            {{ $dia }}
                        </label>
                    @endforeach

                </div>
            </div>

            {{-- Hora inicio --}}
            <div class="mb-3">
                <label class="form-label">Hora inicio</label>
                <input type="time" name="hora_inicio" class="form-control" required>
            </div>

            {{-- Hora fin --}}
            <div class="mb-3">
                <label class="form-label">Hora fin</label>
                <input type="time" name="hora_fin" class="form-control" required>
            </div>

            {{-- Precio --}}
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" name="precio" class="form-control" step="0.01" required>
            </div>

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-3">
                Guardar Tarifa
            </button>
        </form>
    </div>
@endsection