@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Facturas</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Factura</th>
                <th>Fecha</th>
                <th>Monto Total</th>
                <th>Estado del Pedido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $factura)
            <tr>
                <td>{{ $factura->idFactura }}</td>
                <td>{{ $factura->fechaFactura }}</td>
                <td>S/. {{ number_format($factura->montoTotal, 2) }}</td>
                <td>{{ $factura->pedido->estado }}</td>
                <td>
                    <a href="{{ route('cliente.factura.show', $factura->idFactura) }}" class="btn btn-primary">Ver</a>
                    @if($factura->pedido->estado === 'Pendiente')
                        <form action="{{ route('cliente.factura.cancel', $factura->pedido->idPedido) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de cancelar esta factura?');">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">Cancelar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('cliente.index') }}" class="btn btn-secondary mt-3">Regresar</a>
</div>
@endsection
