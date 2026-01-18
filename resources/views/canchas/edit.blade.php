@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Editar Cancha</h5>
                </div>

                <div class="card-body">

                    {{-- Errores --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('canchas.update', $cancha) }}">
                        @csrf
                        @method('PUT')

                        {{-- Empresa --}}
                        <div class="mb-3">
                            <label class="form-label">Empresa</label>
                            <select name="empresa_id" class="form-select" required>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}"
                                        {{ old('empresa_id', $cancha->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label class="form-label">Nombre de la cancha</label>
                            <input type="text"
                                   name="nombre"
                                   class="form-control"
                                   value="{{ old('nombre', $cancha->nombre) }}"
                                   required>
                        </div>

                        {{-- Tipo --}}
                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select">
                                <option value="">Seleccione</option>
                                <option value="futbol"  @selected(old('tipo', $cancha->tipo) == 'futbol')>Fútbol</option>
                                <option value="voley"  @selected(old('tipo', $cancha->tipo) == 'voley')>Voley</option>
                            </select>
                        </div>

                        {{-- Activa --}}
                        <div class="form-check mb-4">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="activa"
                                   id="activa"
                                   value="1"
                                   {{ old('activa', $cancha->activa) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activa">
                                Cancha activa
                            </label>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('canchas.index') }}"
                               class="btn btn-outline-secondary">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Actualizar Cancha
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
