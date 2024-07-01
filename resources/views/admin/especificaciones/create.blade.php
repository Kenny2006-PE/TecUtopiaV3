@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Crear Especificación</h1>
    <form action="{{ route('especificaciones.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombreEspecificacion" class="form-label">Nombre de la Especificación</label>
            <input type="text" class="form-control" id="nombreEspecificacion" name="nombreEspecificacion" required>
        </div>
        <div class="mb-3">
            <label for="idCategoria" class="form-label">Categoría</label>
            <select class="form-control" id="idCategoria" name="idCategoria" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->idCategoria }}">{{ $categoria->nombreCategoria }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('especificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
