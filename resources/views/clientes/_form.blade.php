<div class="card shadow-sm">
    <div class="card-body p-3">

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control form-control-sm"
                    value="{{ old('nombres', $cliente->nombres ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control form-control-sm"
                    value="{{ old('apellidos', $cliente->apellidos ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control form-control-sm"
                    value="{{ old('telefono', $cliente->telefono ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control form-control-sm"
                    value="{{ old('email', $cliente->email ?? '') }}">
            </div>

            <div class="col-md-4">
                <label>Departamento</label>
                <select name="departamento_id" id="departamento" class="form-select">
                    <option value="">Seleccione</option>
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}" {{ isset($departamento) && $departamento->id == $dep->id ? 'selected' : '' }}>
                            {{ $dep->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Provincia</label>
                <select name="provincia_id" id="provincia" class="form-select">
                    <option value="">Seleccione</option>
                    @foreach ($provincias as $prov)
                        <option value="{{ $prov->id }}" {{ isset($provincia) && $provincia->id == $prov->id ? 'selected' : '' }}>
                            {{ $prov->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Distrito</label>
                <select name="distrito_id" id="distrito" class="form-select">
                    <option value="">Seleccione</option>
                    @foreach ($distritos as $dist)
                        <option value="{{ $dist->id }}" {{ old('distrito_id', $cliente->distrito_id ?? '') == $dist->id ? 'selected' : '' }}>
                            {{ $dist->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>


        </div>
    </div>
</div>