<?php

namespace App\Http\Controllers;

use App\Models\Especificacion;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspecificacionController extends Controller
{
    public function index()
    {
        $especificaciones = Especificacion::with('categoria')->get();
        return view('admin.especificaciones.index', compact('especificaciones'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.especificaciones.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreEspecificacion' => 'required|string|max:50',
            'idCategoria' => 'required|exists:categorias,idCategoria',
        ]);

        Especificacion::create($request->all());

        return redirect()->route('especificaciones.index')->with('success', 'Especificación creada correctamente.');
    }

    public function edit($id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $especificacion = Especificacion::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.especificaciones.edit', compact('especificacion', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $request->validate([
            'nombreEspecificacion' => 'required|string|max:50',
            'idCategoria' => 'required|exists:categorias,idCategoria',
        ]);

        $especificacion = Especificacion::findOrFail($id);
        $especificacion->update($request->all());

        return redirect()->route('especificaciones.index')->with('success', 'Especificación actualizada correctamente.');
    }

    public function destroy($id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        Especificacion::findOrFail($id)->delete();
        return redirect()->route('especificaciones.index')->with('success', 'Especificación eliminada correctamente.');
    }
}

