<div class="mb-3">
    <label class="form-label">Nombres</label>
    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $cliente->nombres ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Apellidos</label>
    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $cliente->apellidos ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">Latitud</label>
    <input type="text" name="latitud" class="form-control" value="{{ old('latitud', $cliente->latitud ?? '') }}"
        placeholder="-12.046374">
</div>

<div class="mb-3">
    <label class="form-label">Longitud</label>
    <input type="text" name="longitud" class="form-control" value="{{ old('longitud', $cliente->longitud ?? '') }}"
        placeholder="-77.042793">
</div>

<div class="mb-3">
    <label class="form-label">Estado</label>
    <select name="estado" class="form-select">
        <option value="activo" {{ old('estado', $cliente->estado ?? 'activo') == 'activo' ? 'selected' : '' }}>
            Activo
        </option>
        <option value="inactivo" {{ old('estado', $cliente->estado ?? '') == 'inactivo' ? 'selected' : '' }}>
            Inactivo
        </option>
    </select>
</div>