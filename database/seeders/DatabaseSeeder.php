<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RolSeeder::class);

        
        $Rol = Rol::where('idRol', 5)->first();

        $user = new User();
        $user->nombres = 'alex';
        $user->apellidos = 'hx';
        $user->fechanacimiento = now();
        $user->email = 'alex@gmail.com';
        $user->password = Hash::make('alex12345');
        $user->DNI = '12345678';
        $user->numCelular = '123456789';
        $user->idRol = $Rol->idRol;
        $user->save();
//
        $this->call([
            ClienteSeeder::class,
        ]);

    }
}
