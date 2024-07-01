@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Carrito de Compras</h1>

    @if(session('carrito'))
        <a href="{{ route('cliente.pedido.create') }}" class="btn btn-success">Realizar Pedido</a>
        <form action="{{ route('carrito.clear') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
        </form>
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
                @foreach(session('carrito') as $id => $detalles)
                    @php
                        $valorDescuento = 0;
                        foreach ($detalles['descuentos'] as $descuento) {
                            if ($detalles['cantidad'] >= $descuento->unidadDesc) {
                                $valorDescuento = $descuento->valorDesc;
                            }
                        }
                        $subtotal = $detalles['precio'] * $detalles['cantidad'];
                        $subtotal -= ($valorDescuento * $subtotal);
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td><img src="{{ $detalles['imagen'] }}" width="50" height="50"></td>
                        <td>{{ $detalles['nombre'] }}</td>
                        <td>S/.{{ $detalles['precio'] }}</td>
                        <td>
                            <form action="{{ route('carrito.adicionarOactualizarCarrito') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idProducto" value="{{ $id }}">
                                <input type="number" name="cantidad" value="{{ $detalles['cantidad'] }}" min="3" max="{{ $detalles['cantidad'] + \App\Models\Producto::find($id)->stock }}">
                                <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                            </form>
                        </td>
                        <td>{{ $valorDescuento * 100 }}%</td>
                        <td>S/.{{number_format($subtotal, 2) }}</td>
                        <td>
                            <a href="{{ route('catalogo.producto', $detalles['idProducto']) }}" class="btn btn-warning">
                                Ver Producto
                            </a>
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
                    <td>S/.{{number_format($total, 2) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @else
        <p>Tu carrito está vacío.</p>
    @endif
</div>
@endsection
