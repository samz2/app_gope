@extends('layouts.dashboard')

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

    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
