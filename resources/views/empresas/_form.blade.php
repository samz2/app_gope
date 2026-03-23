<div class="card shadow-sm">
    <div class="card-body p-3">

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombre de la empresa</label>
                <input type="text" name="nombre" class="form-control form-control-sm"
                    value="{{ old('nombre', $empresa->nombre ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Documento</label>
                <input type="text" name="documento" class="form-control form-control-sm"
                    value="{{ old('documento', $empresa->documento ?? '') }}" maxlength="11" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Representante</label>
                <input type="text" name="representante" class="form-control form-control-sm"
                    value="{{ old('representante', $empresa->representante ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control form-control-sm"
                    value="{{ old('telefono', $empresa->telefono ?? '') }}" required>
            </div>

            {{-- FILA SOLO PARA CATEGORÍA --}}
            <div class="col-12">
                <label class="form-label">Categoría</label>
                <select name="categoria" class="form-select form-select-sm w-25">
                    <option value="futbol" @selected(old('categoria', $empresa->categoria ?? '') == 'futbol')>
                        Fútbol
                    </option>
                    <option value="voley" @selected(old('categoria', $empresa->categoria ?? '') == 'voley')>
                        Vóley
                    </option>
                    <option value="polideportivo" @selected(old('categoria', $empresa->categoria ?? '') == 'polideportivo')>
                        Polideportivo
                    </option>
                </select>
            </div>

            {{-- DIRECCIÓN --}}
            <div class="col-12">
                <label class="form-label">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control form-control-sm"
                    value="{{ old('direccion', $empresa->direccion ?? '') }}" required>
                <div id="map" style="height: 350px;" class="mt-2"></div>
            </div>


            {{-- Departamento / Provincia / Distrito --}}
            <div class="col-md-4">
                <label class="form-label">Departamento</label>
                <select id="region" class="form-select form-select-sm" required>
                    <option value="">Seleccione</option>
                    @foreach ($departamentos as $region)
                        <option value="{{ $region->id }}" @selected(($departamentoSeleccionado ?? '') == $region->id)>
                            {{ $region->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Provincia</label>
                <select id="provincia" class="form-select form-select-sm" required></select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Distrito</label>
                <select name="distrito_id" id="distrito" class="form-select form-select-sm" required></select>
            </div>

        </div>

        <input type="hidden" id="latitud" name="latitud" value="{{ old('latitud', $empresa->latitud ?? '') }}">
        <input type="hidden" id="longitud" name="longitud" value="{{ old('longitud', $empresa->longitud ?? '') }}">

    </div>
</div>