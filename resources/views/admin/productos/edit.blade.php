@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>
    <form method="POST" action="{{ route('productos.update', $producto->idProducto) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $producto->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ $producto->descripcion }}</textarea>
        </div>
        <div class="form-group">
            <label for="precioUnitario">Precio Unitario</label>
            <input type="number" name="precioUnitario" id="precioUnitario" class="form-control" value="{{ $producto->precioUnitario }}" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $producto->stock }}" required>
        </div>
        <div class="form-group">
            <label for="idCategoria">Categoría</label>
            <select name="idCategoria" id="idCategoria" class="form-control" required>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->idCategoria }}" {{ $producto->idCategoria == $categoria->idCategoria ? 'selected' : '' }}>{{ $categoria->nombreCategoria }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="popularidad">Popularidad</label>
            <input type="number" name="popularidad" id="popularidad" class="form-control" value="{{ $producto->popularidad }}">
        </div>
        <div class="form-group">
            <label for="image">Imagen</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($producto->image_url)
                <img src="{{ $producto->image_url }}" alt="Imagen del producto" width="200">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
