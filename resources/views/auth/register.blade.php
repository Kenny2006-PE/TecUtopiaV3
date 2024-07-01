@extends('layouts.appAuth')

@section('title', 'Registro')

@section('content')
    <div class="form-container">
        <h1 class="titulo1" style="color: azure; text-shadow: 0px 0px 9px #65ec59; font-size: 30px;">¡Regístrate aquí!</h1><br>
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="nombres" placeholder="Nombres:" required>
            </div><br>
            <div class="form-group">
                <input type="text" class="form-control" name="apellidos" placeholder="Apellidos:" required>
            </div><br>
            <div class="form-group">
                <input type="date" class="form-control" name="fechanacimiento" placeholder="Fecha de Nacimiento:" required>
            </div><br>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Correo Electrónico:" required>
            </div><br>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña:" required>
            </div><br>
            <div class="form-group">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña:" required>
            </div><br>
            <div class="form-group">
                <input type="text" class="form-control" name="DNI" placeholder="DNI:" required>
            </div><br>
            <div class="form-group">
                <input type="text" class="form-control" name="numCelular" placeholder="Número de Celular:" required>
            </div><br>

           <!-- <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="6Leq3MUpAAAAAFGvZwFfBLzIcWtILVSLQvA4hcio"></div>
            </div> -->

            <div class="form-btn">
                <input type="submit" style="color: azure; text-shadow: 0px 0px 9px #508AD3" class="btn-neon" value="Registrar">
            </div>
        </form>
        <div><br>
            <div>
                <p style="color: azure; text-shadow: 0px 0px 9px #508AD3">¿Ya estás registrado? <a href="{{ route('login') }}">Ingresa aquí</a></p>
            </div>
        </div>
    </div>
@endsection
