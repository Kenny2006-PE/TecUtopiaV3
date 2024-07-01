<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\ItemsPedido;
use App\Models\Producto;
use App\Models\Cliente;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $idCliente = Auth::user()->cliente->idCliente;
        $pedidos = Pedido::where('idCliente', $idCliente)->get();
        return view('cliente.pedido.index', compact('pedidos'));
    }

    public function create()
    {
        $cliente = Auth::user()->cliente;

        if ($cliente->RUC === null) {
            return redirect()->route('cliente.perfil')->with('error', 'No puedes realizar pedidos sin tener RUC registrado.');
        }

        $carrito = session()->get('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        return view('cliente.pedido.create', compact('carrito'));
    }

    public function store(Request $request)
    {
        $cliente = Auth::user()->cliente;

        if ($cliente->RUC === null) {
            return redirect()->route('catalogo.index')->with('error', 'No puedes realizar pedidos sin tener RUC registrado.');
        }

        $carrito = session()->get('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        // Crear un nuevo pedido
        $pedido = new Pedido();
        $pedido->idCliente = $cliente->idCliente;
        $pedido->lugarEntrega = $request->input('lugarEntrega');
        $pedido->estado = 'Espera';
        $pedido->masInfo = $request->input('masInfo');
        $pedido->save();

        $total = 0;

        // Guardar los items del pedido
        foreach ($carrito as $idProducto => $detalle) {
            $producto = Producto::find($idProducto);
            $subtotal = $detalle['cantidad'] * $detalle['precio'];
            $valorDescuento = 0;

            foreach ($detalle['descuentos'] as $descuento) {
                if ($detalle['cantidad'] >= $descuento->unidadDesc) {
                    $valorDescuento = $descuento->valorDesc;
                }
            }

            // Aplicar descuento como decimal
            $subtotal -= ($valorDescuento * $subtotal);
            $total += $subtotal;

            ItemsPedido::create([
                'idPedido' => $pedido->idPedido,
                'idProducto' => $idProducto,
                'cantidad' => $detalle['cantidad'],
                'subtotal' => $subtotal,
            ]);

            // Actualizar stock del producto
            $producto->stock -= $detalle['cantidad'];
            $producto->save();
        }

        // Limpiar el carrito
        session()->forget('carrito');

        return redirect()->route('cliente.pedido.show', $pedido->idPedido)->with('success', 'Pedido realizado con éxito.');
    }


    public function cancel()
    {
        session()->forget('carrito');
        return redirect()->route('catalogo.index')->with('success', 'Pedido cancelado.');
    }

    public function show($id)
    {
        $idCliente = Auth::user()->cliente->idCliente;
        $pedido = Pedido::where('idCliente', $idCliente)->where('idPedido', $id)->firstOrFail();
        return view('cliente.pedido.show', compact('pedido'));
    }

    public function eliminarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);

        // Verificar si el usuario tiene permiso para eliminar el pedido
        if (!Auth::user()->esSuperAdmin()) {
            return redirect()->route('cliente.pedido')->with('error', 'No tienes permiso para eliminar este pedido.');
        }

        // Verificar si el pedido está en estado válido para ser eliminado
        if ($pedido->estado !== 'Espera') {
            return redirect()->route('cliente.pedido')->with('error', 'No se puede eliminar este pedido en su estado actual.');
        }

        // Devolver la cantidad de productos al inventario
        foreach ($pedido->itemsPedido as $item) {
            $producto = Producto::find($item->idProducto);
            $producto->stock += $item->cantidad;
            $producto->save();
        }

        // Cambiar estado del pedido a "Eliminado"
        $pedido->estado = 'Eliminado';
        $pedido->save();

        return redirect()->route('cliente.pedido')->with('success', 'El pedido ha sido eliminado correctamente.');
    }

    // Método para devolver los productos al inventario si no se paga después de un día
    public function returnProductsIfNotPaid($idPedido)
    {
        $pedido = Pedido::findOrFail($idPedido);

        // Verificar si el pedido está pendiente de pago y ha pasado más de un día
        if ($pedido->estado === 'Espera' && $pedido->created_at->diffInDays(Carbon::now()) >= 1) {
            // Devolver los productos al inventario
            foreach ($pedido->itemsPedido as $item) {
                $producto = Producto::find($item->idProducto);
                $producto->stock += $item->cantidad;
                $producto->save();
            }

            // Cambiar estado del pedido
            $pedido->estado = 'Cancelado';
            $pedido->save();

            return redirect()->back()->with('warning', 'El pedido ha sido cancelado y los productos han sido devueltos al inventario.');
        }

        return redirect()->back()->with('error', 'No se pueden devolver los productos en este momento.');
    }
}
