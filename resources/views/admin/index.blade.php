@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1 class="text-center">Bienvenido Admin</h1>
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text">Gestión de usuarios</p>
                    <a href="{{ route('admin.usuarios') }}" class="btn btn-primary">Ver Usuarios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Productos</h5>
                    <p class="card-text">Gestión de productos</p>
                    <a href="{{ route('productos.index') }}" class="btn btn-primary">Ver Productos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Categorías</h5>
                    <p class="card-text">Gestión de categorías</p>
                    <a href="{{ route('categorias.index') }}" class="btn btn-primary">Ver Categorías</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Especificaciones</h5>
                    <p class="card-text">Gestión de especificaciones</p>
                    <a href="{{ route('especificaciones.index') }}" class="btn btn-primary">Ver Especificaciones</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Pedidos</h5>
                    <p class="card-text">Gestión de pedidos</p>
                    <a href="{{ route('admin.pedidos') }}" class="btn btn-primary">Ver Pedidos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
