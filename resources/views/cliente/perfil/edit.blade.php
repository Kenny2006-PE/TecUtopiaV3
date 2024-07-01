@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Perfil de Cliente</h1>
    <form action="{{ route('cliente.actualizarPerfil') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" name="nombres" id="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $cliente->usuario->nombres) }}" required>
            @error('nombres')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $cliente->usuario->apellidos) }}" required>
            @error('apellidos')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="numCelular">Celular</label>
            <input type="text" name="numCelular" id="numCelular" class="form-control @error('numCelular') is-invalid @enderror" value="{{ old('numCelular', $cliente->usuario->numCelular) }}" required>
            @error('numCelular')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if ($cliente->RUC == null)
        <div class="form-group">
            <label for="RUC">RUC</label>
            <input type="text" name="RUC" id="RUC" class="form-control @error('RUC') is-invalid @enderror" value="{{ old('RUC') }}" autocomplete="off">
            @error('RUC')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @else
        <div class="form-group">
            <label for="RUC">RUC</label>
            <input type="text" name="RUC" id="RUC" class="form-control" value="{{ $cliente->RUC }}" readonly>
        </div>
        @endif
        <div class="form-group">
            <label for="current_password">Contraseña Actual</label>
            <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="off">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Nueva Contraseña</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div><br>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('cliente.perfil') }}"><button type="button" class="btn btn-secondary">Cancelar</button></a>
    </form>
</div>
@endsection
