<div class="row p-1">
    <div class="col-md-12">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name ?? '') }}"
                required>
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email ?? '') }}"
                required>
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                {{ $user->exists ? '' : 'required' }}>
            @if($user->exists)
                <div class="form-text">Dejar en blanco para mantener la contraseña actual</div>
            @endif
            {!! $errors->first('password', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                {{ $user->exists ? '' : 'required' }}>
            {!! $errors->first('password_confirmation', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select
                name="role"
                id="role"
                class="form-select @error('role') is-invalid @enderror"
                required>
                @foreach(['empleado','cliente','administrador'] as $r)
                    <option value="{{ $r }}"
                        {{ old('role', $user->role ?? 'cliente') === $r ? 'selected' : '' }}>
                        {{ ucfirst($r) }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('role', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>

    <div class="col-md-12 mt-2 d-flex justify-content-start">
        <button type="submit" class="btn btn-primary me-2">
            {{ __('Enviar') }}
        </button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
            {{ __('Cancelar') }}
        </a>
    </div>
</div>
