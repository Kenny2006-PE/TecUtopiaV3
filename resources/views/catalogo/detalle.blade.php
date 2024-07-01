@extends('layouts.app')

@section('title', 'Detalle del Producto - ' . $producto->nombre)

@section('content')
<div class="container detalles-container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="img-fluid rounded-start">
                        <h1 class="mt-3">{{ $producto->nombre }}</h1>
                        <p><strong>Precio:</strong> S/.{{ $producto->precioUnitario }}</p>
                        <p> <strong>Stock:</strong>  {{$producto->stock}} und. </p>
                        <p>{{ $producto->descripcion }}</p>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h3>Características</h3>
                            <ul class="list-group list-group-flush mb-3">
                                @foreach($especificaciones as $especificacion)
                                    <li class="list-group-item">{{ $especificacion->nombreEspecificacion }}: {{ $especificacion->pivot->valorEspecificacion }}</li>
                                @endforeach
                            </ul>
                            <h3>Descuentos</h3>
                            <ul class="list-group list-group-flush mb-3">
                                @foreach($descuentos as $descuento)
                                    <li class="list-group-item">{{ $descuento->unidadDesc }} und. x {{ $descuento->valorDesc * 100 }}%</li>
                                @endforeach
                            </ul>
                            
                            <form action="{{ route('carrito.adicionarOactualizarCarrito') }}" method="POST">
                            
                                @csrf
                                <input type="hidden" name="idProducto" value="{{ $producto->idProducto }}">
                                <div class="mb-3">
                                    <label for="cantidad" class="form-label">Cantidad:</label>
                                    <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ session('carrito')[$producto->idProducto]['cantidad'] ?? 3 }}" min="3" max="{{ $producto->stock }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                            </form>
                            <a href="{{ route('catalogo.index') }}" class="btn btn-secondary mt-3">Volver al catálogo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
