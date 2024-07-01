@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Crear Producto</h1>
    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="precioUnitario">Precio Unitario</label>
            <input type="number" name="precioUnitario" id="precioUnitario" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="idCategoria">Categoría</label>
            <select name="idCategoria" id="idCategoria" class="form-control" required>
                @foreach ($categorias as $categoria)
                <option value="{{ $categoria->idCategoria }}">{{ $categoria->nombreCategoria }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="popularidad">Popularidad</label>
            <input type="number" name="popularidad" id="popularidad" class="form-control">
        </div>
        <div class="form-group">
            <label for="image" class="form-label">Imagen (opcional)</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection