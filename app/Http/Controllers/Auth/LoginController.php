<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Producto;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        switch ($user->idRol) {
            case 1: // Admin
                return redirect()->route('admin.index');
            case 2: // jefealmacen
                return redirect()->route('admin.index');
            case 3: // cliente
                return redirect()->route('catalogo.index');
            case 5:
                return redirect()->route('admin.index');
            default:
                Auth::logout();
                return redirect('/')->with('error', 'Su cuenta está inhabilitada.');
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        Log::info('Cerrando sesión para el usuario: ' . $user->email);

        $carrito = session()->get('carrito', []);

        foreach ($carrito as $id => $item) {
            $producto = Producto::find($id);
            if ($producto) {
                $producto->stock += $item['cantidad'];
                $producto->save();
            }
        }

        session()->forget('carrito');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Cache::forget('user-' . $user->idUsuario);

        return redirect('/login')->with('message', 'Has cerrado sesión correctamente.');
    }
}
