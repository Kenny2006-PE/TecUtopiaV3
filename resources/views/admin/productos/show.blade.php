@extends('layouts.appAdmin')

@section('content')
    <div class="card">
        <div class="card-header">
            Detalle de Producto
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $producto->nombre }}</h5>
            <p class="card-text">{{ $producto->descripcion }}</p>
            <p class="card-text">Precio: ${{ $producto->precioUnitario }}</p>
            <p class="card-text">Stock: {{ $producto->stock }}</p>
            <!-- Mostrar imagen si existe -->
            @if ($producto->imagen_url)
                <img src="{{ $producto->imagen_url }}" class="img-fluid" alt="Imagen del producto">
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('productos.edit', $producto->idProducto) }}" class="btn btn-primary">Editar Producto</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Especificaciones
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($producto->especificaciones as $especificacion)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $especificacion->nombreEspecificacion }}: {{ $especificacion->pivot->valorEspecificacion }}
                            <div class="btn-group" role="group" aria-label="Acciones">
                                <a href="{{ route('productos.especificaciones.edit', ['idProducto' => $producto->idProducto, 'idEspecificacion' => $especificacion->idEspecificacion]) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('productos.especificaciones.destroy', ['idProducto' => $producto->idProducto, 'idEspecificacion' => $especificacion->idEspecificacion]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="card-footer">
                    <a href="{{ route('productos.especificaciones.create', $producto->idProducto) }}" class="btn btn-primary">Agregar Especificaciones</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Descuentos
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($producto->descuentos as $descuento)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Por {{ $descuento->unidadDesc }} unidades un {{ $descuento->valorDesc }}% de descuento
                            <div class="btn-group" role="group">
                                <a href="{{ route('productos.descuentos.edit', ['id' => $descuento->idDescuento]) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('productos.descuentos.destroy', ['id' => $descuento->idDescuento]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este descuento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="card-footer">
                    <a href="{{ route('productos.descuentos.create', $producto->idProducto) }}" class="btn btn-warning">Agregar Descuentos</a>
                </div>
            </div>
        </div>
    </div>
@endsection
