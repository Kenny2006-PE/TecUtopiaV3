@extends('layouts.appAdmin')

@section('content')
    <div class="container">
        <h1 class="text-center">Editar Usuario</h1>
        <form method="POST" action="{{ route('admin.update-usuario', $usuario->idUsuario) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" value="{{ old('nombres', $usuario->nombres) }}" required>
                @error('nombres')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" required>
                @error('apellidos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fechanacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control @error('fechanacimiento') is-invalid @enderror" id="fechanacimiento" name="fechanacimiento" value="{{ old('fechanacimiento', $usuario->fechanacimiento) }}" required>
                @error('fechanacimiento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="DNI">DNI</label>
                <input type="text" class="form-control @error('DNI') is-invalid @enderror" id="DNI" name="DNI" value="{{ old('DNI', $usuario->DNI) }}" required>
                @error('DNI')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numCelular">Número de Celular</label>
                <input type="text" class="form-control @error('numCelular') is-invalid @enderror" id="numCelular" name="numCelular" value="{{ old('numCelular', $usuario->numCelular) }}" required>
                @error('numCelular')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if(Auth::user()->rol->nombreRol === 'SuperAdmin')
                <div class="form-group">
                    <label for="idRol">Rol</label>
                    <select class="form-control @error('idRol') is-invalid @enderror" id="idRol" name="idRol" required>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->idRol }}" {{ old('idRol', $usuario->idRol) == $rol->idRol ? 'selected' : '' }}>{{ $rol->nombreRol }}</option>
                        @endforeach
                    </select>
                    @error('idRol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
            @else
                <input type="hidden" name="idRol" value="{{ $usuario->idRol }}">
            @endif

            @if($usuario->cliente && !in_array($usuario->rol->nombreRol, ['Admin', 'JefeAlmacen']))
                <div class="form-group">
                    <label for="credito">Crédito</label>
                    <input type="number" class="form-control @error('credito') is-invalid @enderror" id="credito" name="credito" value="{{ old('credito', $usuario->cliente->credito) }}" min="0" step="1">
                    @error('credito')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="RUC">RUC</label>
                    <input type="text" class="form-control @error('RUC') is-invalid @enderror" id="RUC" name="RUC" value="{{ old('RUC', $usuario->cliente->RUC) }}">
                    @error('RUC')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>
@endsection
