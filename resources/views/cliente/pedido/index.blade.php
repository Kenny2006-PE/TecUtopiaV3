@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Pedidos</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($pedidos->isEmpty())
        <p>No tienes pedidos.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Más Información</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->idPedido }}</td>
                        <td>{{ $pedido->created_at }}</td>
                        <td>{{ $pedido->estado }}</td>
                        <td>{{ $pedido->masInfo }}</td>
                        <td>
                            <a href="{{ route('cliente.pedido.show', $pedido->idPedido) }}" class="btn btn-info">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
    <a href="{{ route('cliente.index') }}" class="btn btn-secondary">Volver</a>


@endsection
