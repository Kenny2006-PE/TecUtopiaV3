<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\User;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $user = User::whereHas('rol', function ($query) {
            $query->where('idRol', 5);
        })->first();

        if ($user) {
            $cliente = new Cliente();
            $cliente->credito = 5000;
            $cliente->RUC = '12345678912';
            $cliente->idUsuario = $user->idUsuario;
            $cliente->save();
        }
    }
}
