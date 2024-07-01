<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Descuento;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Actualizar los descuentos si es que hay nuevos descuentos aplicables
        $carrito = session()->get('carrito', []);

        foreach ($carrito as $key => $detalles) {
            $producto = Producto::findOrFail($detalles['idProducto']);
            $descuentos = Descuento::where('idProducto', $producto->idProducto)->get();
            $carrito[$key]['descuentos'] = $descuentos;
        }

        session()->put('carrito', $carrito);

        return view('cliente.carrito.index', compact('carrito'));
    }

    public function adicionarOactualizarCarrito(Request $request)
    {
        $request->validate([
            'idProducto' => 'required|exists:productos,idProducto',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::findOrFail($request->idProducto);
        $descuentos = Descuento::where('idProducto', $producto->idProducto)->get();
        $cantidad = max(3, min($request->input('cantidad', 3), $producto->stock));

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$request->idProducto])) {
            $oldCantidad = $carrito[$request->idProducto]['cantidad'];
            $newCantidad = max(3, min($request->input('cantidad'), $producto->stock + $oldCantidad));

            $producto->stock += ($oldCantidad - $newCantidad);
            $producto->save();

            $carrito[$request->idProducto]['cantidad'] = $newCantidad;
        } else {
            $carrito[$request->idProducto] = [
                "idProducto" => $producto->idProducto,
                "nombre" => $producto->nombre,
                "cantidad" => $cantidad,
                "precio" => $producto->precioUnitario,
                "imagen" => $producto->imagen_url,
                "descuentos" => $descuentos
            ];
            $producto->stock -= $cantidad;
            $producto->save();
        }

        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Producto añadido/actualizado en el carrito!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'idProducto' => 'required|exists:productos,idProducto'
        ]);

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$request->idProducto])) {
            $producto = Producto::findOrFail($request->idProducto);
            $producto->stock += $carrito[$request->idProducto]['cantidad'];
            $producto->save();

            unset($carrito[$request->idProducto]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito!');
    }

    public function clear()
    {
        $carrito = session()->get('carrito', []);

        foreach ($carrito as $id => $item) {
            $producto = Producto::findOrFail($id);
            $producto->stock += $item['cantidad'];
            $producto->save();
        }

        session()->forget('carrito');

        return redirect()->route('catalogo.index')->with('success', 'Carrito limpiado!');
    }
}
