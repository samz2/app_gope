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
        <input type="text" id="direccion" name="direccion" class="form-control"
            value="{{ $empresa->direccion }}" required>
        <div id="map" style="height: 400px; width: 100%;"></div>
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
    <div class="mb-3">
        <label class="form-label">Departamento</label>
        <select name="departamento_id" id="departamento" class="form-control">
            <option value="">-- Seleccione Departamento --</option>
            @foreach($departamentos as $dep)
                <option value="{{ $dep->id }}"
                    {{ $departamentoSeleccionado == $dep->id ? 'selected' : '' }}>
                    {{ $dep->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Provincia</label>
        <select name="provincia_id" id="provincia" class="form-control">
            <option value="">-- Seleccione Provincia --</option>
            @foreach($provincias as $prov)
                <option value="{{ $prov->id }}"
                    {{ $provinciaSeleccionada == $prov->id ? 'selected' : '' }}>
                    {{ $prov->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Distrito</label>
        <select name="distrito_id" id="distrito" class="form-control">
            <option value="">-- Seleccione Distrito --</option>
            @foreach($distritos as $dist)
                <option value="{{ $dist->id }}"
                    {{ $distritoSeleccionado == $dist->id ? 'selected' : '' }}>
                    {{ $dist->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <input type="hidden" id="latitud" name="latitud"
       value="{{ old('latitud', $empresa->latitud ?? '') }}">

    <input type="hidden" id="longitud" name="longitud"
       value="{{ old('longitud', $empresa->longitud ?? '') }}">
    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
<script>
    document.getElementById('departamento').addEventListener('change', function () {
        fetch(`/provincias/${this.value}`)
            .then(res => res.json())
            .then(data => {
                let provincia = document.getElementById('provincia');
                provincia.innerHTML = '<option value="">-- Seleccione Provincia --</option>';
                data.forEach(p => {
                    provincia.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
                });
                document.getElementById('distrito').innerHTML =
                    '<option value="">-- Seleccione Distrito --</option>';
            });
    });

    document.getElementById('provincia').addEventListener('change', function () {
        fetch(`/distritos/${this.value}`)
            .then(res => res.json())
            .then(data => {
                let distrito = document.getElementById('distrito');
                distrito.innerHTML = '<option value="">-- Seleccione Distrito --</option>';
                data.forEach(d => {
                    distrito.innerHTML += `<option value="${d.id}">${d.nombre}</option>`;
                });
            });
    });
</script>
@endsection
