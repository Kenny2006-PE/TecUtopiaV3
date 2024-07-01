@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <h1 class="display-4">Bienvenido, {{ Auth::user()->nombres }}</h1>
    <p class="lead">Selecciona una opción del menú para continuar.</p>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pedidos</h5>
                <p class="card-text">Consulta tus pedidos anteriores y su estado.</p>
                <a href="{{ route('cliente.pedido') }}" class="btn btn-primary">Ver Pedidos</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Perfil</h5>
                <p class="card-text">Ver y actualizar tu información de perfil.</p>
                <a href="{{ route('cliente.perfil') }}" class="btn btn-primary">Ver Perfil</a>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Facturas</h5>
                <p class="card-text">Consulta las facturas de tus compras.</p>
                <a href="{{ route('cliente.factura') }}" class="btn btn-primary">Ver Facturas</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Historial</h5>
                <p class="card-text">Historial de movimientos en la pagina.</p>
                <a href="{{ route('cliente.historial') }}" class="btn btn-primary">Ver Historial</a>
            </div>
        </div>
    </div>
</div>
@endsection