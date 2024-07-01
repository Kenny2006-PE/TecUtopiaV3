@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Listado de Productos</h1>
    
    <div class="d-flex justify-content-between mb-3">
    <form method="GET" action="{{ route('productos.index') }}" class="form-inline w-100 d-flex justify-content-between">
        <div class="form-group d-flex mr-2 align-items-center">
            <label for="search" class="mr-2">Buscar</label>
            <input type="text" name="search" id="search" class="form-control mr-2" value="{{ request('search') }}">
        </div>
        <div class="form-group d-flex mr-2 align-items-center">
            <label for="category" class="mr-2">Categoría</label>
            <select name="category" id="category" class="form-control mr-2">
                <option value="">Todas</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->nombreCategoria }}" {{ request('category') == $categoria->idCategoria ? 'selected' : '' }}>{{ $categoria->nombreCategoria }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>

    <a href="{{ route('productos.create') }}" class="btn btn-primary">Crear Producto</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio Unitario</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Popularidad</th>
                <th>Imagen</th>
                <th>Código Producto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->idProducto }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->precioUnitario }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->categoria->nombreCategoria }}</td>
                    <td>{{ $producto->popularidad }}</td>
                    <td><img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" width="50"></td>
                    <td>{{ $producto->codigoProducto }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->idProducto) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $producto->idProducto) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                        <a href="{{ route('productos.show', $producto->idProducto) }}" class="btn btn-info">Ver Detalles</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
