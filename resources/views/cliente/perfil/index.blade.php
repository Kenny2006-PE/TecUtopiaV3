@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perfil de Cliente</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $cliente->usuario->nombres }} {{ $cliente->usuario->apellidos }}</p>
            <p><strong>Email:</strong> {{ $cliente->usuario->email }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $cliente->usuario->fechanacimiento }}</p>
            <p><strong>DNI:</strong> {{ $cliente->usuario->DNI }}</p>
            <p><strong>RUC:</strong> {{ $cliente->RUC }}</p>
            <p><strong>Crédito:</strong> {{  number_format($cliente->credito,2) }}</p>
            <p><strong>Celular:</strong> {{ $cliente->usuario->numCelular }}</p>
            <a href="{{ route('cliente.editarPerfil') }}" class="btn btn-primary">Editar Perfil</a>
            
            <a href="{{ route('cliente.index') }}" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
</div>
@endsection
