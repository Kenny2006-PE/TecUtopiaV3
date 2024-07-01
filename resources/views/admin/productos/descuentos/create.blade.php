@extends('layouts.appAdmin')

@section('content')
    <div class="card">
        <div class="card-header">
            Agregar Descuento para {{ $producto->nombre }}
        </div>
        <div class="card-body">
            <form action="{{ route('productos.descuentos.store', $producto->idProducto) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="unidadDesc">Unidad de Descuento</label>
                    <input type="number" class="form-control" id="unidadDesc" name="unidadDesc" min="0" required>
                </div>
                <div class="form-group">
                    <label for="valorDesc">Valor Descuento</label>
                    <input type="number" step="0.01" class="form-control" id="valorDesc" name="valorDesc" min="0" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Descuento</button>
                <a href="{{ route('productos.show', $producto->idProducto) }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
