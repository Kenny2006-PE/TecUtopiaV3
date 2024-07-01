@extends('layouts.appAdmin')

@section('content')
    <div class="card">
        <div class="card-header">
            Agregar Especificación para {{ $producto->nombre }}
        </div>
        <div class="card-body">
            <form action="{{ route('productos.especificaciones.store', ['idProducto' => $producto->idProducto]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="idEspecificacion">Especificación</label>
                    <select class="form-control" id="idEspecificacion" name="idEspecificacion">
                        @if ($especificaciones->isEmpty())
                            <option disabled>No hay más especificaciones disponibles para agregar.</option>
                        @else
                            @foreach ($especificaciones as $esp)
                                @php
                                    $asociada = $producto->especificaciones->contains('idEspecificacion', $esp->idEspecificacion);
                                @endphp
                                @unless($asociada)
                                    <option value="{{ $esp->idEspecificacion }}">{{ $esp->nombreEspecificacion }}</option>
                                @endunless
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="valorEspecificacion">Valor Especificación</label>
                    <input type="text" class="form-control" id="valorEspecificacion" name="valorEspecificacion" required>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">Agregar Especificación</button>
                    <a href="{{ route('productos.show', $producto->idProducto) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>

            <div id="mensajeEspecificaciones" class="mt-2">
                @if ($especificaciones->isEmpty())
                    <small class="text-muted">No hay más especificaciones disponibles para agregar.</small>
                @endif
            </div>
        </div>
    </div>
@endsection
