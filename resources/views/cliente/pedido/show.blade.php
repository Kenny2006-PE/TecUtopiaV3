@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del Pedido</h1>

    <h3>Pedido ID: {{ $pedido->idPedido }}</h3>
    <p>Estado: {{ $pedido->estado }}</p>
    <p>Lugar de Entrega: {{ $pedido->lugarEntrega }}</p>
    <p>Más Información: {{ $pedido->masInfo }}</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Precio x Cantidad</th>
                <th>Descuento</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp

            @foreach($pedido->itemsPedido as $item)
            <tr>
                <td>{{ $item->producto->nombre }}</td>
                <td>S/. {{ number_format($item->producto->precioUnitario, 2) }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>S/. {{ number_format($item->producto->precioUnitario * $item->cantidad, 2) }}</td>
                <td>S/. {{ number_format($item->subtotal - $item->producto->precioUnitario * $item->cantidad, 2) }}</td>
                <td>S/. {{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @php
                $total += $item->subtotal;
            @endphp
            @endforeach
            
            <tr>
                <td class="text-right"><strong>Total:</strong></td>
                <td colspan="4"></td>
                <td >S/. {{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @if ($pedido->estado === 'Espera')
        <div class="mt-3">
            <a href="{{ route('cliente.factura.create', $pedido->idPedido) }}" class="btn btn-success">Pagar Pedido</a>
            <form action="{{ route('cliente.pedido.eliminar', $pedido->idPedido) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este pedido?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger ml-2">Eliminar Pedido</button>
            </form>
        </div>
    @elseif ($pedido->estado === 'Pendiente')
        <div class="mt-3">
            <form action="{{ route('cliente.factura.cancel', $pedido->idPedido) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar este pedido?');">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-warning ml-2">Cancelar Factura</button>
            </form>
        </div>
    @endif

    <a href="{{ route('cliente.pedido') }}" class="btn btn-secondary mt-3">Regresar</a>
</div>
@endsection
