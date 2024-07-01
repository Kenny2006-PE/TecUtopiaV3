<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        //cuando este con cuenta
        if (Auth::check()) {
            $user = Auth::user();
            $idCliente = $user->cliente->idCliente;
            //crear sesion idcliente
            
            session(['idCliente' => $idCliente]);
            
            // rol del usuario
            $userRole = $user->rol->nombreRol;

            if ($userRole === 'SuperAdmin') {
                return $this->setNoCacheHeaders($next($request));
            }
            //tener registro de los datos
            Log::info('Rol del usuario: ' . $userRole);
            Log::info('Roles permitidos: ' . implode(', ', $roles));

            // resolucion de problema que no se obtiene el rol a la primera
            if (empty($roles) || $roles[0] === ' ') {
                Log::warning('Roles permitidos están vacíos o incorrectos');
                session(['checked_roles' => true]);
                return $this->setNoCacheHeaders($next($request));
            }

            // segunda pregunta si se obtiene rol pasa sino se le niega
            if (session('checked_roles', false)) {
                //se elimina la sesion para la proxima autentificaion
                session()->forget('checked_roles');

                //verificar ahora si si coincide con su rol
                if (in_array($userRole, $roles)) {
                    return $this->setNoCacheHeaders($next($request));
                
                } else {
                    Log::warning('Acceso no autorizado para el usuario: ' . $user->email);

                    //para evitar la redireccion en bucle
                    $redirectCount = session('redirect_count', 0);
                    $redirectCount++;
                    session(['redirect_count' => $redirectCount]);

                    // si se llega a tres veces de redireccion se le cierra la sesion y bota a login
                    if ($redirectCount > 3) {
                        //borrar la redireccion para la procima vez que pase pero solo es para seguridad que se de 
                        //ya que eh puesto para que se elimine el cache
                        session()->forget('redirect_count');
                        Auth::logout();
                        return redirect('/login')->with('error', 'Acceso no autorizado, por favor inicie sesión nuevamente.');
                    }

                    return redirect()->back()->with('error', 'Acceso no autorizado, regresado al punto anterior.');
                }
            }
        }

        // si no esta autentificado se va a login
        Log::warning('Usuario no autenticado intentando acceder a una ruta protegida.');
        return $this->setNoCacheHeaders($next($request));
    }

    // para que la cache no funcione en este midleware para que los usuarios sean autentificados correctamente
    private function setNoCacheHeaders($response)
    {
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}
