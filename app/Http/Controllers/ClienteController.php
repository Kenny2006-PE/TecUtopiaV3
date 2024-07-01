<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use App\Models\Pedido;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('cliente.index');
    }

    public function perfil()
    {
        // Obtener el cliente autenticado
        $cliente = Auth::user()->cliente;

        // Asegurarse de que el cliente esté definido
        if (!$cliente) {
            return redirect()->route('cliente.index')->with('error', 'No se encontró el perfil del cliente.');
        }

        return view('cliente.perfil.index', compact('cliente'));
    }

    public function editarPerfil()
    {
        // Obtener el cliente autenticado
        $cliente = Auth::user()->cliente;

        // Asegurarse de que el cliente esté definido
        if (!$cliente) {
            return redirect()->route('cliente.index')->with('error', 'No se encontró el perfil del cliente.');
        }

        return view('cliente.perfil.edit', compact('cliente'));
    }

    public function actualizarPerfil(Request $request)
    {
        // Obtener el cliente y el usuario autenticados
        $cliente = Auth::user()->cliente;
        $user = Auth::user();

        // Validar los datos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'numCelular' => 'required|string|max:9|min:9',
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Verificar si el RUC ha sido establecido y no permitir cambios posteriores
        if ($cliente->RUC == null) {
            $request->validate([
                'RUC' => 'nullable|string|max:11|unique:clientes,RUC,' . $cliente->idCliente . ',idCliente',
            ]);
            $cliente->RUC = $request->input('RUC');
        }

        $cliente->save();

        // Actualizar los datos del usuario
        $user->nombres = $request->input('nombres');
        $user->apellidos = $request->input('apellidos');
        $user->numCelular = $request->input('numCelular');

        // Verificar y actualizar la contraseña si es necesario
        if ($request->filled('current_password') && $request->filled('password')) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('password'));
            } else {
                return redirect()->back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }
        }

        $user->save();

        return redirect()->route('cliente.perfil')->with('success', 'Datos actualizados correctamente.');
    }

    public function historial(Request $request)
    {
        $cliente = Auth::user()->cliente;

        $query = Pedido::with('itemsPedido.producto')
            ->where('idCliente', $cliente->idCliente);

        // Filtrar por el criterio seleccionado
        switch ($request->input('filter')) {
            case 'nuevo':
                $query->orderBy('created_at', 'desc');
                break;
            case 'antiguo':
                $query->orderBy('created_at', 'asc');
                break;
            case 'cantidad':
                $query->withCount('itemsPedido as cantidad_total')
                    ->orderBy('cantidad_total', 'desc');
                break;
            case 'costo':
                $query->withSum('itemsPedido as costo_total', 'subtotal')
                    ->orderBy('costo_total', 'desc');
                break;
        }

        $pedidos = $query->get();

        return view('cliente.historial', compact('pedidos'));
    }
}
