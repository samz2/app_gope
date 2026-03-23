<div class="row g-3">

    {{-- Cliente --}}
    <div class="col-md-6">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-control">
            <option value="">Seleccione cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">
                    {{ $cliente->nombres }} {{ $cliente->apellidos ?? '' }}
                </option>
            @endforeach
        </select>

    </div>

    {{-- Cancha --}}
    <div class="col-md-6">
        <label class="form-label">Cancha</label>
        <select name="cancha_id" class="form-select form-select-sm" required>
            <option value="">-- Seleccione cancha --</option>
            @foreach($canchas as $cancha)
                <option value="{{ $cancha->id }}">
                    {{ $cancha->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Fecha --}}
    <div class="col-md-4">
        <label class="form-label">Fecha</label>
        <input type="date" name="fecha" class="form-control form-control-sm" required>
    </div>

    {{-- Hora inicio --}}
    <div class="col-md-4">
        <label class="form-label">Hora inicio</label>
        <input type="time" name="hora_inicio" class="form-control form-control-sm" required>
    </div>

    {{-- Hora fin --}}
    <div class="col-md-4">
        <label class="form-label">Hora fin</label>
        <input type="time" name="hora_fin" class="form-control form-control-sm" required>
    </div>

    {{-- Disponibilidad --}}
    <div class="col-12">
        <div id="info-disponibilidad" class="alert py-1 mt-2" style="display:none;"></div>
    </div>

    {{-- Precio --}}
    <div class="col-md-4">
        <label class="form-label">Precio total</label>
        <input type="text" name="precio" class="form-control form-control-sm" readonly>
    </div>

</div>