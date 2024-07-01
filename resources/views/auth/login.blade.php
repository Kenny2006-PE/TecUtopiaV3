@extends('layouts.appAuth')

@section('title', 'Login Form')

@section('content')
<div class="form-container">
    <h1 class="titulo1" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-size: 30px;">¡Inicia Sesión!</h1><br>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Correo electrónico:">
        </div><br>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Contraseña:">
        </div><br>

        <div class="form-btn">
            <input type="submit" style="color:azure;text-shadow: 0px 0px 9px #508AD3" class="btn-neon" value="Ingresar">
        </div>
    </form>
    <div><br>
        <div>
            <p style="color:azure;text-shadow: 0px 0px 9px #508AD3">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
        </div>
    </div>
</div>
@endsection
