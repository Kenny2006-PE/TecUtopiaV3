<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Factura;
use App\Models\Pedido;
use Carbon\Carbon;

class FacturaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Visualización de las facturas realizadas por el usuario autenticado
    public function index()
    {
        $facturas = Factura::with('cliente')->where('idCliente', Auth::user()->cliente->idCliente)->get();
        return view('cliente.factura.index', compact('facturas'));
    }

    public function create($idPedido)
    {
        $pedido = Pedido::with('itemsPedido.producto')->findOrFail($idPedido);
        $cliente = Auth::user()->cliente;

        // Verificar que el pedido pertenezca al cliente autenticado y esté en estado Espera
        if ($pedido->idCliente !== $cliente->idCliente || $pedido->estado !== 'Espera') {
            return redirect()->route('cliente.pedido.show', $idPedido)->with('error', 'El pedido no está en estado pendiente o no te pertenece. Contacte con uno de los administradores.');
        }

        // Calcular el monto total del pedido
        $montoTotal = 0;
        foreach ($pedido->itemsPedido as $item) {
            $montoTotal += $item->subtotal;
        }

        // Verificar que el cliente tenga suficientes créditos
        if ($cliente->credito < $montoTotal) {
            // Calcular tiempo restante para pagar
            $tiempoRestante = $pedido->created_at->addDay()->diffForHumans(Carbon::now(), true);

            return redirect()->route('cliente.pedido.show', $idPedido)->with('error', 'Créditos insuficientes. Tiempo restante para pagar: ' . $tiempoRestante);
        }

        return view('cliente.factura.create', compact('pedido', 'montoTotal', 'cliente'));
    }

    public function store(Request $request, $idPedido)
    {
        $pedido = Pedido::with('itemsPedido')->findOrFail($idPedido);
        $cliente = Auth::user()->cliente;

        // Verificar que el pedido pertenezca al cliente autenticado y esté en estado Pendiente
        if ($pedido->idCliente !== $cliente->idCliente || $pedido->estado !== 'Espera') {
            return redirect()->route('cliente.pedido.show', $idPedido)->with('error', 'El pedido no está en estado pendiente o no te pertenece. Contacte con uno de los administradores.');
        }

        // Calcular el monto total del pedido
        $montoTotal = 0;
        foreach ($pedido->itemsPedido as $item) {
            $montoTotal += $item->subtotal;
        }

        // Verificar que el cliente tenga suficientes créditos
        if ($cliente->credito < $montoTotal) {
            // Calcular tiempo restante para pagar
            $tiempoRestante = $pedido->created_at->addDay()->diffForHumans(Carbon::now(), true);

            return redirect()->route('cliente.pedido.show', $idPedido)->with('error', 'Créditos insuficientes. Tiempo restante para pagar: ' . $tiempoRestante);
        }

        // Crear factura
        $factura = new Factura();
        $factura->idCliente = $cliente->idCliente;
        $factura->idPedido = $pedido->idPedido;
        $factura->montoTotal = $montoTotal;
        $factura->fechaFactura = Carbon::now();
        $factura->save();

        // Reducir el crédito del cliente
        $cliente->credito -= $montoTotal;
        $cliente->save();

        // Incrementar la popularidad de los productos
        foreach ($pedido->itemsPedido as $item) {
            $producto = $item->producto;
            $producto->popularidad += $item->cantidad;
            $producto->save();
        }

        // Cambiar el estado del pedido a Pagado
        $pedido->estado = 'Pendiente';
        $pedido->save();

        return redirect()->route('cliente.pedido.show', $idPedido)->with('success', 'Pago realizado con éxito. La factura ha sido generada.');
    }

    public function cancel($idPedido)
    {
        $pedido = Pedido::with('itemsPedido.producto')->findOrFail($idPedido);
        $cliente = Auth::user()->cliente;

        // Verificar que el pedido pertenezca al cliente autenticado y esté en estado Pendiente
        if ($pedido->idCliente !== $cliente->idCliente || $pedido->estado !== 'Pendiente' || $pedido->estado !== 'Fallido') {
            return redirect()->route('cliente.pedido.show', $idPedido)->with('error', 'El pedido no está en estado pendiente o no te pertenece. Contacte con uno de los administradores.');
        }

        // Cambiar el estado del pedido a Cancelado
        $pedido->estado = 'Cancelado';
        $pedido->save();

        // Devolver el crédito correspondiente al cliente
        $creditoDevuelto = 0;
        foreach ($pedido->itemsPedido as $item) {
            $creditoDevuelto += $item->subtotal;
            // Devolver la cantidad al stock del producto
            $producto = $item->producto;
            $producto->stock += $item->cantidad;
            $producto->save();
        }
        $cliente->credito += $creditoDevuelto;
        $cliente->save();

        return redirect()->route('cliente.pedido.show', $idPedido)->with('success', 'El pedido ha sido cancelado y los créditos han sido devueltos.');
    }

    public function show($idFactura)
    {
        $factura = Factura::with('pedido.itemsPedido.producto')->findOrFail($idFactura);
        $cliente = Auth::user()->cliente;

        // Verificar que la factura pertenezca al cliente autenticado
        if ($factura->idCliente !== $cliente->idCliente) {
            return redirect()->route('cliente.factura.index')->with('error', 'No tienes permiso para ver esta factura.');
        }

        return view('cliente.factura.show', compact('factura'));
    }

    public function confirmarEntrega($idFactura)
    {
        // Obtener la factura y el pedido relacionados
        $factura = Factura::findOrFail($idFactura);
        $pedido = $factura->pedido;

        // Verificar que el usuario autenticado sea el dueño del pedido
        if (Auth::id() != $pedido->idCliente) {
            return redirect()->route('cliente.historial')->with('error', 'No tiene permiso para realizar esta acción.');
        }

        // Verificar el estado del pedido
        if ($pedido->estado === 'En Curso' || $pedido->estado === 'A Recoger') {
            $pedido->estado = 'Entregado';
            $pedido->save();

            return redirect()->route('cliente.historial')->with('success', 'Pedido marcado como entregado.');
        }

        return redirect()->route('cliente.historial')->with('error', 'El estado del pedido no se puede cambiar.');
    }

}
