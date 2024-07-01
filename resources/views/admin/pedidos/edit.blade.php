@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1 class="text-center">Gestión de Pedidos</h1>
    <div class="row mt-5">
        @foreach($pedidos as $pedido)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Pedido ID: {{ $pedido->idPedido }}</h5>
                    <p>Email: {{ $pedido->cliente->usuario->email }}</p>
                    <p>Teléfono: {{ $pedido->cliente->usuario->numCelular }}</p>
                    <p>Lugar de Entrega: {{ $pedido->lugarEntrega }}</p>
                    <p>Más Información: {{ $pedido->masInfo }}</p>
                    <ul>
                        @foreach($pedido->itemsPedido as $item)
                            <li>{{ $item->producto->nombre }} - Cantidad: {{ $item->cantidad }} - Precio Unitario: S/. {{ number_format($item->producto->precioUnitario, 2) }} - Subtotal: S/. {{ number_format($item->subtotal, 2) }}</li>
                        @endforeach
                    </ul>
                    <p>Total: S/. {{ number_format($pedido->itemsPedido->sum('subtotal'), 2) }}</p>
                    <p>Estado: {{ $pedido->estado }}</p>
                    <form action="{{ route('admin.pedido.updateEstado', $pedido->idPedido) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="estado" class="form-control mb-2">
                            <option value="">Seleccionar estado</option>
                            <option value="En Curso" {{ $pedido->estado == 'En Curso' ? 'selected' : '' }}>En Curso</option>
                            <option value="A Recoger" {{ $pedido->estado == 'A Recoger' ? 'selected' : '' }}>A Recoger</option>
                            @if(Auth::user()->rol->nombreRol === 'SuperAdmin')
                                <option value="Espera" {{ $pedido->estado == 'Espera' ? 'selected' : '' }}>Espera</option>
                                <option value="Fallido" {{ $pedido->estado == 'Fallido' ? 'selected' : '' }}>Fallido</option>
                                <option value="Pendiente" {{ $pedido->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            @endif
                            @if(Auth::user()->rol->nombreRol === 'Admin')
                                <option value="Fallido" {{ $pedido->estado == 'Fallido' ? 'selected' : '' }}>Fallido</option>
                                <option value="Pendiente" {{ $pedido->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            
                            @endif
                        </select>
                        <button type="submit" class="btn btn-primary" {{ $pedido->estado == '' ? 'disabled' : '' }}>Actualizar Estado</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
