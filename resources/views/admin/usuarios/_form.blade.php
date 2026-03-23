<div class="card shadow-sm">
    <div class="card-body p-3">

        <div class="row g-3">
            <div class="mb-3">
                <label for="role_id" class="form-label">Rol</label>
                <select name="role_id" id="role_id" class="form-select" required>
                    <option value="">Seleccione un rol</option>

                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                            {{ $role->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="empresa_id" class="form-label">Empresa</label>
                <select name="empresa_id" id="empresa_id" class="form-select" required>
                    <option value="">Seleccione una empresa</option>

                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ old('empresa_id', $user->empresa_id ?? '') == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control form-control-sm"
                    value="{{ old('usuario', optional($user)->usuario) }}" required>
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
        </div>
    </div>
</div>