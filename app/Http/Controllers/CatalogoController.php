<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\ProductoEspecificacion;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sortBy = $request->input('sort_by', 'nombre');
        $sortOrder = $request->input('sort_order', 'asc');

        $productos = Producto::query()
            ->with('categoria')
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'like', "%$search%")
                    ->orWhere('descripcion', 'like', "%$search%");
            })
            ->when($category, function ($query, $category) {
                if ($category == 'novedades') {
                    return $query->orderBy('created_at', 'desc');
                } else {
                    return $query->whereHas('categoria', function ($q) use ($category) {
                        $q->where('nombreCategoria', $category);
                    });
                }
            })
            ->when($minPrice, function ($query, $minPrice) {
                return $query->where('precioUnitario', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query, $maxPrice) {
                return $query->where('precioUnitario', '<=', $maxPrice);
            })
            ->where('stock', '>=', 3)
            ->orderBy($sortBy, $sortOrder)
            ->get();

        $categorias = Categoria::all();

        return view('catalogo.index', compact('productos', 'categorias', 'search', 'category', 'minPrice', 'maxPrice', 'sortBy', 'sortOrder'));
    }

    public function show($id)
    { {
            $producto = Producto::findOrFail($id);

            // Obtener las especificaciones del producto
            $especificaciones = $producto->especificaciones;

            // Obtener los descuentos del producto
            $descuentos = $producto->descuentos;

            return view('catalogo.detalle', compact('producto', 'especificaciones', 'descuentos'));
        }
    }
}
