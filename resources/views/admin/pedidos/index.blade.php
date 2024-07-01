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
                    <p>Estado Actual: <strong>{{ $pedido->estado }}</strong></p>
                    <form action="{{ route('admin.pedido.updateEstado', $pedido->idPedido) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="estado" class="form-control mb-2" id="estadoSelect-{{ $pedido->idPedido }}">
                            <option value="">Seleccione un nuevo estado</option>
                            <option value="En Curso" {{ $pedido->estado == 'En Curso' ? 'selected' : '' }}>En Curso</option>
                            <option value="A Recoger" {{ $pedido->estado == 'A Recoger' ? 'selected' : '' }}>A Recoger</option>
                            @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'SuperAdmin')
                                <option value="Fallido" {{ $pedido->estado == 'Fallido' ? 'selected' : '' }}>Fallido</option>
                                <option value="Pendiente" {{ $pedido->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            @endif
                            @if(Auth::user()->role == 'SuperAdmin')
                                <option value="Espera" {{ $pedido->estado == 'Espera' ? 'selected' : '' }}>Espera</option>
                            @endif
                        </select>
                        <button type="submit" class="btn btn-primary" id="submitBtn-{{ $pedido->idPedido }}">Actualizar Estado</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        @foreach($pedidos as $pedido)
            const estadoSelect = document.getElementById('estadoSelect-{{ $pedido->idPedido }}');
            const submitBtn = document.getElementById('submitBtn-{{ $pedido->idPedido }}');
            
            estadoSelect.addEventListener('change', function() {
                if (this.value) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            });
        @endforeach
    });
</script>
@endsection
