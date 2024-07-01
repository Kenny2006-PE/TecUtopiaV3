@extends('layouts.appAdmin')

@section('content')
    <div class="card">
        <div class="card-header">
            Editar Descuento para {{ $producto->nombre }}
        </div>
        <div class="card-body">
            <form action="{{ route('productos.descuentos.update', $descuento->idDescuento) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="unidadDesc">Unidad de Descuento</label>
                    <input type="number" class="form-control" id="unidadDesc" name="unidadDesc" value="{{ $descuento->unidadDesc }}" min="0" required>
                </div>
                <div class="form-group">
                    <label for="valorDesc">Valor Descuento</label>
                    <input type="number" step="0.01" class="form-control" id="valorDesc" name="valorDesc" value="{{ $descuento->valorDesc }}" min="0" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Descuento</button>
                <a href="{{ route('productos.show', $producto->idProducto) }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
