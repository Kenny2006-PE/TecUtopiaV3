@extends('layouts.appAdmin')

@section('content')
    <div class="container">
        <h1 class="text-center">Listado de Usuarios</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombres }}</td>
                        <td>{{ $usuario->apellidos }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->rol->nombreRol }}</td>
                        <td>
                            @if(Auth::user()->rol->nombreRol === 'SuperAdmin' || $usuario->rol->nombreRol !== 'SuperAdmin')
                                <a href="{{ route('admin.edit-usuario', $usuario->idUsuario) }}" class="btn btn-primary">Editar</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
