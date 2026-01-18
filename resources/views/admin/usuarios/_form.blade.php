<div class="mb-3">
    <label for="role_id" class="form-label">Rol</label>
    <select name="role_id" id="role_id" class="form-select" required>
        <option value="">Seleccione un rol</option>

        @foreach ($roles as $role)
            <option value="{{ $role->id }}"
                {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                {{ $role->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name', optional($user)->name) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email', optional($user)->email) }}" required>
</div>



{{-- SOLO EN CREATE --}}
@if (!isset($user))
    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control form-control-sm" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
    </div>
@endif