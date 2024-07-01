@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Editar Categoría</h1>
    <form action="{{ route('categorias.update', $categoria->idCategoria) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombreCategoria" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" value="{{ $categoria->nombreCategoria }}" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
