@extends('layouts.app')

@section('content')
<h1>Editar Empresa</h1>

<form action="{{ route('empresas.update', $empresa) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text"
               name="nombre"
               class="form-control"
               value="{{ $empresa->nombre }}"
               required>
    </div>
    <div class="mb-3">
        <label class="form-label">Documento</label>
        <input type="text" name="documento" class="form-control"
            value="{{ $empresa->documento }}" maxlength="11" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Representante</label>
        <input type="text" name="representante" class="form-control"
            value="{{ $empresa->representante }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Telefono</label>
        <input type="text" name="telefono" class="form-control"
            value="{{ $empresa->telefono }}" maxlength="11" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control"
            value="{{ $empresa->direccion }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Categoria</label>
        <select name="categoria" class="form-control">
            <option value="futbol" {{ $empresa->categoria == 'futbol' ? 'selected' : '' }}>
                Futbol
            </option>
            <option value="voley" {{ $empresa->categoria == 'voley' ? 'selected' : '' }}>
                Voley
            </option>
            <option value="polideportivo" {{ $empresa->categoria == 'polideportivo' ? 'selected' : '' }}>
                Polideportivo
            </option>
        </select>
    </div>
    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
