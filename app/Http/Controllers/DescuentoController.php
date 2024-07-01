<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Descuento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DescuentoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($idProducto)
    {
        $producto = Producto::findOrFail($idProducto);
        return view('admin.productos.descuentos.create', compact('producto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idProducto)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Establecer el límite de descuento según el rol del usuario
        $maxDescuento = 1.0; // Sin límite para SuperAdmin

        if ($user->rol === 'JefeAlmacen') {
            $maxDescuento = 0.5;
        } elseif ($user->rol === 'Admin') {
            $maxDescuento = 0.9;
        }

        $request->validate([
            'unidadDesc' => 'required|integer|min:0',
            'valorDesc' => 'required|numeric|min:0|max:' . $maxDescuento,
        ]);

        Descuento::create([
            'idProducto' => $idProducto,
            'unidadDesc' => $request->unidadDesc,
            'valorDesc' => $request->valorDesc,
        ]);

        return redirect()->route('productos.show', $idProducto)->with('success', 'Descuento agregado correctamente.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $descuento = Descuento::findOrFail($id);
        $producto = Producto::findOrFail($descuento->idProducto);
        return view('admin.productos.descuentos.edit', compact('producto', 'descuento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Establecer el límite de descuento según el rol del usuario
        $maxDescuento = 1.0; // Sin límite para SuperAdmin

        if ($user->rol === 'JefeAlmacen') {
            $maxDescuento = 0.5;
        } elseif ($user->rol === 'Admin') {
            $maxDescuento = 0.9;
        }

        $request->validate([
            'unidadDesc' => 'required|integer|min:0',
            'valorDesc' => 'required|numeric|min:0|max:' . $maxDescuento,
        ]);

        $descuento = Descuento::findOrFail($id);
        $descuento->unidadDesc = $request->unidadDesc;
        $descuento->valorDesc = $request->valorDesc;
        $descuento->save();

        return redirect()->route('productos.show', $descuento->idProducto)->with('success', 'Descuento actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $descuento = Descuento::findOrFail($id);
        $idProducto = $descuento->idProducto;
        $descuento->delete();
        return redirect()->route('productos.show', $idProducto)->with('success', 'Descuento eliminado correctamente.');
    }
}
