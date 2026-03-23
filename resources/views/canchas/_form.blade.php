<div class="card shadow-sm">
    <div class="card-body p-3">

        {{-- Empresa --}}
        @if(auth()->user()->role->nombre === 'admin')
            <div class="mb-3">
                <label class="form-label">Empresa</label>
                <select name="empresa_id" class="form-select form-select-sm" required>
                    <option value="">Seleccione una empresa</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ old('empresa_id', $cancha->empresa_id ?? '') == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="empresa_id" value="{{ auth()->user()->empresa->id }}">
        @endif

        {{-- Nombre --}}
        <div class="mb-3">
            <label class="form-label">Nombre de la cancha</label>
            <input type="text" name="nombre" class="form-control form-control-sm"
                value="{{ old('nombre', $cancha->nombre ?? '') }}" required>
        </div>

        {{-- Tipo --}}
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select form-select-sm">
                <option value="">Seleccione</option>
                <option value="futbol" {{ old('tipo', $cancha->tipo ?? '') === 'futbol' ? 'selected' : '' }}>Fútbol
                </option>
                <option value="voley" {{ old('tipo', $cancha->tipo ?? '') === 'voley' ? 'selected' : '' }}>Vóley</option>
            </select>
        </div>

        {{-- Imágenes --}}
        <div class="mb-3">
            <label class="form-label">Imágenes</label>
            <input type="file" name="imagenes[]" class="form-control form-control-sm" multiple accept="image/*">
        </div>

        {{-- Activa --}}
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="activa" id="activa" value="1" {{ 
                old(
        'activa',
        isset($cancha) ? $cancha->activa : true
    ) ? 'checked' : '' 
           }}>
    <label class="form-check-label" for="activa">
                Cancha activa
            </label>
        </div>

    </div>
</div>