@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Confirmación de Pedido</h1>

    <form action="{{ route('cliente.pedido.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="lugarEntrega" class="form-label">Lugar de Entrega:</label>
            <input type="text" name="lugarEntrega" id="lugarEntrega" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="masInfo" class="form-label">Información Adicional:</label>
            <textarea name="masInfo" id="masInfo" class="form-control"></textarea>
        </div>

        
        <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
        <a href="{{ route('carrito.index') }}" class="btn btn-secondary">Cancelar Pedido</a>
    </form>
    <h2>Productos en el Pedido</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach($carrito as $id => $detalles)
                @php
                    $totalDescuento = 0;
                    foreach ($detalles['descuentos'] as $descuento) {
                        if ($detalles['cantidad'] >= $descuento->unidadDesc) {
                            $totalDescuento = $descuento->valorDesc;
                        }
                    }
                    $subtotal = $detalles['precio'] * $detalles['cantidad'] - ($totalDescuento * $detalles['precio']);
                    $total += $subtotal;
                @endphp
                <tr>
                    <td><img src="{{ $detalles['imagen'] }}" width="50" height="50"></td>
                    <td>{{ $detalles['nombre'] }}</td>
                    <td>S/.{{number_format($detalles['precio'], 2) }}</td>
                    <td>{{ $detalles['cantidad'] }}</td>
                    <td>{{ $totalDescuento * 100 }}%</td>
                    <td>S/.{{number_format($subtotal, 2) }}</td>
                    <td>
                        <form action="{{ route('carrito.adicionarOactualizarCarrito') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="idProducto" value="{{ $id }}">
                            <input type="number" name="cantidad" value="{{ $detalles['cantidad'] }}" min="3" max="{{ $detalles['cantidad'] + \App\Models\Producto::find($id)->stock }}">
                            <button type="submit" class="btn btn-primary btn-sm">Editar</button>
                        </form>
                        <form action="{{ route('carrito.remove') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="idProducto" value="{{ $id }}">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-right"><strong>Total:</strong></td>
                <td><strong>S/.{{number_format($total, 2) }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
