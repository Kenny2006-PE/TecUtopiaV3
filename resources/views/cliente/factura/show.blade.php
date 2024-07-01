@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de la Factura</h1>

    <h3>Factura ID: {{ $factura->idFactura }}</h3>
    <p>Cliente: {{ $factura->cliente->usuario->nombres ." ".$factura->cliente->usuario->apellidos }}</p>
    <p>Teléfono: {{ $factura->cliente->usuario->numCelular }}</p>
    <p>RUC: {{$factura->cliente->RUC}} </p>
    <p>Fecha: {{ $factura->fechaFactura }}</p>
    <p>Monto Total: S/. {{ number_format($factura->montoTotal, 2) }}</p>

    <h3>Pedido ID: {{ $factura->pedido->idPedido }}</h3>
    <p>Lugar de Entrega: {{ $factura->pedido->lugarEntrega }}</p>
    <p>Más Información: {{ $factura->pedido->masInfo }}</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Código</th>
                <th>Precio x Cantidad</th>
                <th>Descuento</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factura->pedido->itemsPedido as $item)
            <tr>
                <td><img src="{{ $item->producto->imagen_url }}" class="img-thumbnail" width="100"></td>
                <td>{{ $item->producto->nombre }}</td>
                <td>{{ $item->producto->codigoProducto }}</td>
                <td>S/. {{ number_format($item->producto->precioUnitario * $item->cantidad, 2) }}</td>
                <td>S/. {{ number_format($item->subtotal - $item->producto->precioUnitario * $item->cantidad, 2) }}</td>
                <td>S/. {{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($factura->pedido->estado === 'En Curso' || $factura->pedido->estado === 'A Recoger')
        <form action="{{ route('cliente.factura.confirmar', $factura->idFactura) }}" method="POST" onsubmit="return confirm('¿Estás seguro de marcar este pedido como entregado? Una vez marcado, no se podrá cambiar.');">
            @csrf
            <button type="submit" class="btn btn-success mt-3">Marcar como Entregado</button>
        </form>
    @endif

    <a href="{{ route('cliente.factura') }}" class="btn btn-secondary mt-3">Regresar</a>
</div>
@endsection
