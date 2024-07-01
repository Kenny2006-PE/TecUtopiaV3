<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Cliente;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'fechanacimiento' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'DNI' => ['required','string', 'unique:usuarios'],
            'numCelular' => ['required','string', 'unique:usuarios'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'fechanacimiento' => $data['fechanacimiento'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'DNI' => $data['DNI'],
            'numCelular' => $data['numCelular'],
            'idRol' => 3,
        ]);

        Cliente::create([
            'credito' => 50,
            'RUC' => null,
            'idUsuario' => $user->idUsuario,
        ]);

        return $user;
    }
}
