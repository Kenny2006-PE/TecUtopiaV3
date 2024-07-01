<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\ProductoEspecificacion;
use App\Models\Especificacion;
use App\Models\Descuento;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $productos = Producto::query()
            ->with('categoria')
            ->when($search, function ($query, $search) {
                return $query->where('idProducto', 'like', "%$search%")
                             ->orWhere('nombre', 'like', "%$search%");
            })
            ->when($category, function ($query, $category) {
                return $query->whereHas('categoria', function ($q) use ($category) {
                    $q->where('nombreCategoria', $category);
                });
            })
            ->get();

        $categorias = Categoria::all();

        return view('admin.productos.index', compact('productos', 'categorias', 'search', 'category'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required',
            'precioUnitario' => 'required|numeric',
            'stock' => 'required|integer',
            'idCategoria' => 'required|exists:categorias,idCategoria',
            'popularidad' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $uploadFile = Cloudinary::upload($request->file('image')->getRealPath());
            $imageUrl = $uploadFile->getSecurePath();
        }

        $categoria = Categoria::findOrFail($request->idCategoria);
        $prefix = strtoupper(substr($categoria->nombreCategoria, 0, 4));
        $codigoProducto = $prefix . '-' . Str::random(5) . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precioUnitario' => $request->precioUnitario,
            'stock' => $request->stock,
            'idCategoria' => $request->idCategoria,
            'popularidad' => $request->popularidad,
            'imagen_url' => $imageUrl,
            'codigoProducto' => $codigoProducto,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function show($id){
        $producto = Producto::with('especificaciones')->find($id);
        $categoriaProducto = $producto->categoria;

        $especificaciones = Especificacion::where('idCategoria', $categoriaProducto->idCategoria)->get();
    
        return view('admin.productos.show', compact('producto', 'especificaciones'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required',
            'precioUnitario' => 'required|numeric',
            'stock' => 'required|integer',
            'idCategoria' => 'required|exists:categorias,idCategoria',
            'popularidad' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $producto = Producto::findOrFail($id);
        if ($request->hasFile('image')) {
            $uploadFile = Cloudinary::upload($request->file('image')->getRealPath());
            $producto->imagen_url = $uploadFile->getSecurePath();
        }

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precioUnitario' => $request->precioUnitario,
            'stock' => $request->stock,
            'idCategoria' => $request->idCategoria,
            'popularidad' => $request->popularidad,
            'imagen_url' => $producto->imagen_url,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        Producto::findOrFail($id)->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function addEspecificacion(Request $request, $idProducto)
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

    public function addDescuento(Request $request, $idProducto)
    {
        $request->validate([
            'unidadDesc' => 'required|integer|min:0',
            'valorDesc' => 'required|numeric|min:0',
        ]);

        Descuento::create([
            'idProducto' => $idProducto,
            'unidadDesc' => $request->unidadDesc,
            'valorDesc' => $request->valorDesc,
        ]);

        return redirect()->route('productos.show', $idProducto)->with('success', 'Descuento agregado correctamente.');
    }
}
