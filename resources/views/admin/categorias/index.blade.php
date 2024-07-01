@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Listado de Categorías</h1>
    <a href="{{ route('categorias.create') }}" class="btn btn-primary">Crear Categoría</a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->idCategoria }}</td>
                    <td>{{ $categoria->nombreCategoria }}</td>
                    <td>
                        <a href="{{ route('categorias.edit', $categoria->idCategoria) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('categorias.destroy', $categoria->idCategoria) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
