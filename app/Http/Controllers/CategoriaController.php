<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreCategoria' => 'required|string|max:50|unique:categorias,nombreCategoria',
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit($id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $request->validate([
            'nombreCategoria' => 'required|string|max:50|unique:categorias,nombreCategoria,' . $id . ',idCategoria',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy($id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        Categoria::findOrFail($id)->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
