<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Especificacion;
use App\Models\ProductoEspecificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoEspecificacionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($idProducto)
    {
        $producto = Producto::findOrFail($idProducto);
        $especificaciones = Especificacion::where('idCategoria', $producto->idCategoria)->get();
        return view('admin.productos.especificaciones.create', compact('producto', 'especificaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idProducto)
    {
        $request->validate([
            'idEspecificacion' => 'required|exists:especificaciones,idEspecificacion',
            'valorEspecificacion' => 'required|string|max:200',
        ]);

        ProductoEspecificacion::create([
            'idProducto' => $idProducto,
            'idEspecificacion' => $request->idEspecificacion,
            'valorEspecificacion' => $request->valorEspecificacion,
        ]);

        return redirect()->route('productos.show', $idProducto)->with('success', 'Especificación agregada correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idProducto, $idEspecificacion)
{
    $productoEspecificacion = ProductoEspecificacion::findOrCreate($idProducto, $idEspecificacion);
    $producto = Producto::findOrFail($idProducto);
    $productoEspecificacion = ProductoEspecificacion::where('idProducto', $idProducto)
        ->where('idEspecificacion', $idEspecificacion)
        ->firstOrFail();

    return view('admin.productos.especificaciones.edit', compact('productoEspecificacion', 'productoEspecificacion'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idProducto, $idEspecificacion)
{
    // Validación de los datos recibidos
    $request->validate([
        'valorEspecificacion' => 'required|string|max:255',
    ]);

    // Actualizar el valor de la especificación usando el Query Builder
    $affected = DB::table('producto_especificaciones')
                    ->where('idProducto', $idProducto)
                    ->where('idEspecificacion', $idEspecificacion)
                    ->update(['valorEspecificacion' => $request->valorEspecificacion]);

    if ($affected) {
        // Redirigir con un mensaje de éxito si se actualizó correctamente
        return redirect()->route('productos.show', $idProducto)->with('success', 'Especificación actualizada correctamente.');
    } else {
        // Manejar el caso donde no se encontró la instancia para actualizar
        return redirect()->back()->with('error', 'No se pudo actualizar la especificación.');
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idProducto, $idEspecificacion)
{
    ProductoEspecificacion::where('idProducto', $idProducto)
        ->where('idEspecificacion', $idEspecificacion)
        ->delete();

    return redirect()->route('productos.show', $idProducto)->with('success', 'Especificación eliminada correctamente.');
}
}
