@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Factura</h1>
    <p>Pedido #{{ $pedido->idPedido }}</p>
    <p>Cliente: {{ $cliente->usuario->nombres ." ".$cliente->usuario->apellidos }}</p>
    <p>Teléfono: {{ $cliente->usuario->numCelular }}</p>
    <p>RUC: {{$cliente->RUC}} </p>
    <p>Fecha de Pedido: {{ $pedido->created_at->format('d/m/Y') }}</p>
    <p>Créditos Disponibles: S/.{{ number_format($cliente->credito, 2) }}</p>
    <p>Monto Total del Pedido: S/.{{ number_format($montoTotal, 2) }}</p>
    <p>Créditos Después del Pago: S/.{{ number_format($cliente->credito - $montoTotal, 2) }}</p>
    <p>Lugar de Entrega: {{ $pedido->lugarEntrega }}</p>
    <p>Más Información: {{ $pedido->masInfo }}</p>

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
            @foreach($pedido->itemsPedido as $item)
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

    <form action="{{ route('cliente.factura.store', $pedido->idPedido) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Pagar y Generar Factura</button>
    </form>
</div>
@endsection
