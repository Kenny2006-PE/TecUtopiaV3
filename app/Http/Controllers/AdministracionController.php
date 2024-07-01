<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pedido;

class AdministracionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function usuarios()
    {
        // verificar que no sea jefealamacen
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $usuarios = User::all();
        return view('admin.usuarios', compact('usuarios'));
    }

    public function editUsuario($id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $usuario = User::findOrFail($id);
        $roles = Rol::all();
        return view('admin.edit-usuario', compact('usuario', 'roles'));
    }

    public function updateUsuario(Request $request, $id)
    {
        if (Auth::user()->rol->nombreRol === 'JefeAlmacen') {
            return redirect()->back()->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        $usuario = User::findOrFail($id);
        $currentUser = Auth::user();

        // Verificar si el usuario no es SuperAdmin y está intentando editar un SuperAdmin
        if ($currentUser->rol->nombreRol !== 'SuperAdmin' && $usuario->rol->nombreRol === 'SuperAdmin') {
            return redirect()->route('admin.usuarios')->with('error', 'No tienes permisos para editar este usuario.');
        }

        // Verificar si el usuario no es SuperAdmin y está intentando cambiar el rol de otro usuario
        if ($currentUser->rol->nombreRol !== 'SuperAdmin' && $request->idRol != $usuario->idRol) {
            return redirect()->route('admin.usuarios')->with('error', 'No tienes permisos para cambiar el rol de este usuario.');
        }

        // Validar los datos del formulario
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fechanacimiento' => 'required|date',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->idUsuario . ',idUsuario',
            'DNI' => 'required|string|max:255',
            'numCelular' => 'required|string|max:255',
            'idRol' => 'required|exists:roles,idRol',
            'credito' => ($currentUser->rol->nombreRol === 'SuperAdmin') ? 'nullable|numeric|min:0' : 'nullable',
            'RUC' => ($currentUser->rol->nombreRol === 'SuperAdmin') ? 'nullable|string|max:255' : 'nullable',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        // Hash de la contraseña si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Actualizar el usuario con los datos validados
        $usuario->update($data);

        // Si el usuario es un cliente y el usuario actual es SuperAdmin, actualizar los datos del cliente
        if ($usuario->cliente || $currentUser->rol->nombreRol === 'SuperAdmin') {
            $clienteData = [
                'credito' => $data['credito'],
                'RUC' => $data['RUC']
            ];
            $usuario->cliente->update($clienteData);
        }

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado con éxito.');
    }

    public function pedidos()
    {
        // Obtener todos los pedidos ordenados por fecha de más antiguo a más reciente
        $pedidos = Pedido::with('cliente.usuario', 'itemsPedido.producto')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.pedidos.index', compact('pedidos'));
    }

    /**
     * Actualizar el estado del pedido
     */
    public function updateEstadoPedido(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string',
        ]);

        $pedido = Pedido::findOrFail($id);

        // Verifica el rol del usuario y el estado permitido
        $nuevoEstado = $request->estado;
        $rolUsuario = Auth::user()->rol->nombreRol;

        $estadosPermitidos = [
            'JefeAlmacen' => ['En Curso', 'A Recoger'],
            'Admin' => ['En Curso', 'A Recoger', 'Fallido', 'Pendiente'],
            'SuperAdmin' => ['En Curso', 'A Recoger', 'Fallido', 'Pendiente', 'Espera']
        ];

        if (!in_array($nuevoEstado, $estadosPermitidos[$rolUsuario])) {
            return back()->withErrors(['msg' => 'No tienes permisos para poner el pedido en este estado.']);
        }

        try {
            $pedido->estado = $nuevoEstado;
            $pedido->save();

            return back()->with('success', 'Estado del pedido actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Hubo un problema al actualizar el estado del pedido.'])->withInput();
        }
    }
}
