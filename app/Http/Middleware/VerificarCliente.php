<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerificarCliente
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $idCliente = $user->cliente->idCliente;

            if ($request->route('idCliente') && $idCliente != $request->route('idCliente')) {
                Log::warning('Acceso no autorizado para el usuario: ' . $user->email);
                return redirect()->back()->with('error', 'Acceso no autorizado.');
            }

            $request->merge(['idCliente' => $idCliente]);
        } else {
            Log::warning('Usuario no autenticado intentando acceder a una ruta protegida.');
            return redirect()->route('login')->with('error', 'Debe iniciar sesión primero.');
        }

        return $next($request);
    }
}
