@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Crear Categoría</h1>
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombreCategoria" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
