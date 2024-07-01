@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Historial de Compras</h1>

    <div class="mb-3">
        <form action="{{ route('cliente.historial') }}" method="GET">
            <div class="form-group">
                <label for="filter">Filtrar por:</label>
                <select name="filter" id="filter" class="form-control">
                    <option value="nuevo">Más reciente</option>
                    <option value="antiguo">Más antiguo</option>
                    <option value="cantidad">Cantidad de productos</option>
                    <option value="costo">Costo total</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Aplicar Filtro</button>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Cantidad Total</th>
                <th>Costo Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->idPedido }}</td>
                <td>{{ $pedido->created_at }}</td>
                <td>
                    <ul>
                        @foreach($pedido->itemsPedido as $item)
                            <li>{{ $item->producto->nombre }} ({{ $item->cantidad }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $pedido->itemsPedido->sum('cantidad') }}</td>
                <td>S/. {{ number_format($pedido->itemsPedido->sum('subtotal'), 2) }}</td>
                <td>{{ $pedido->estado }}</td>
                <td>
                    @if($pedido->estado === 'Pendiente')
                        <a href="{{ route('cliente.factura.show', $pedido->factura->idFactura) }}" class="btn btn-primary">Ver Factura</a>
                        <form action="{{ route('cliente.factura.cancel', $pedido->factura->idFactura) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de cancelar esta factura?');">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">Cancelar Factura</button>
                        </form>
                    @elseif($pedido->estado === 'Cancelado')
                        <a href="{{ route('cliente.factura.show', $pedido->factura->idFactura) }}" class="btn btn-warning">Factura Cancelada</a>
                    @elseif($pedido->estado === 'Espera')
                        <a href="{{ route('cliente.factura.create', $pedido->idPedido) }}" class="btn btn-success">Pagar Factura</a>
                    @elseif($pedido->estado === 'En Curso' || $pedido->estado === 'A Recoger')
                        <a href="{{ route('cliente.pedido.show', $pedido->idPedido) }}" class="btn btn-primary">Ver Factura</a>
                    @elseif($pedido->estado === 'Fallido')
                        <a href="{{ route('cliente.factura.cancel', $pedido->factura->idFactura) }}" class="btn btn-primary">Cancelar Factura</a>
                    @elseif($pedido->estado =='Eliminado')
                        <a href="{{ route('cliente.pedido.show', $pedido->idPedido) }}" class="btn btn-primary">Ver Pedido</a>
                        <form action="{{ route('cliente.pedido.eliminar', $pedido->idPedido) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este pedido?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar Pedido</button>
                        </form>
                    @elseif($pedido->estado =='Entregado')
                    <a href="{{ route('cliente.factura.show', $pedido->factura->idFactura) }}" class="btn btn-warning">Pedido Finalizado</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('cliente.index') }}" class="btn btn-secondary mt-3">Regresar</a>
</div>
@endsection
