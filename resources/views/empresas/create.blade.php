@extends('layouts.dashboard')

@section('content')
<h1>Nueva Empresa</h1>

<form method="POST" action="{{ route('empresas.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Documento</label>
        <input type="text" name="documento" class="form-control" maxlength="11" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Representante</label>
        <input type="text" name="representante" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Telefono</label>
        <input type="text" name="telefono" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" required>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection
