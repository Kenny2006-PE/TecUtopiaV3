@extends('layouts.appAdmin')

@section('content')
    <div class="card">
        <div class="card-header">
            Editar Especificación para {{ $productoEspecificacion->producto->nombre }}
        </div>
        <div class="card-body">
            <form action="{{ route('productos.especificaciones.update', ['idProducto' => $productoEspecificacion->idProducto, 'idEspecificacion' => $productoEspecificacion->idEspecificacion]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="idEspecificacion">Especificación</label>
                    <select class="form-control" id="idEspecificacion" name="idEspecificacion" disabled>
                        <option value="{{ $productoEspecificacion->especificacion->idEspecificacion }}" selected>
                            {{ $productoEspecificacion->especificacion->nombreEspecificacion }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="valorEspecificacion">Valor Especificación</label>
                    <input type="text" class="form-control" id="valorEspecificacion" name="valorEspecificacion" value="{{ old('valorEspecificacion', $productoEspecificacion->valorEspecificacion) }}" required>
                    @error('valorEspecificacion')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Especificación</button>
                <a href="{{ route('productos.show', $productoEspecificacion->idProducto) }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
