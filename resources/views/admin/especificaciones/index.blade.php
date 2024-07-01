@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1>Listado de Especificaciones</h1>
    <a href="{{ route('especificaciones.create') }}" class="btn btn-primary">Crear Especificación</a>
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($especificaciones as $especificacion)
                <tr>
                    <td>{{ $especificacion->idEspecificacion }}</td>
                    <td>{{ $especificacion->nombreEspecificacion }}</td>
                    <td>{{ $especificacion->categoria->nombreCategoria }}</td>
                    <td>
                        <a href="{{ route('especificaciones.edit', $especificacion->idEspecificacion) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('especificaciones.destroy', $especificacion->idEspecificacion) }}" method="POST" style="display:inline-block;">
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
