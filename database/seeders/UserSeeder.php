<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 2 administradores
        User::create([
            'carnet_identidad' => 'A123456789',
            'name' => 'Admin 1',  // Usando 'name' en lugar de 'nombre_completo'
            'email' => 'admin1@ejemplo.com',
            'password' => Hash::make('password123'),  // Cambia la contraseña por una segura
            'role' => 'admin',
        ]);

        User::create([
            'carnet_identidad' => 'A987654321',
            'name' => 'Admin 2',  // Usando 'name' en lugar de 'nombre_completo'
            'email' => 'admin2@ejemplo.com',
            'password' => Hash::make('password123'),  // Cambia la contraseña por una segura
            'role' => 'admin',
        ]);

        // Crear 10 microempresarios
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'carnet_identidad' => 'MIE' . str_pad($i, 9, '0', STR_PAD_LEFT),
                'name' => 'Microempresa ' . $i,  // Usando 'name' en lugar de 'nombre_completo'
                'email' => 'microempresa' . $i . '@ejemplo.com',
                'password' => Hash::make('password123'),  // Cambia la contraseña por una segura
                'role' => 'microempresa',
            ]);
        }

        // Crear 20 clientes
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'carnet_identidad' => 'CLI' . str_pad($i, 9, '0', STR_PAD_LEFT),
                'name' => 'Cliente ' . $i,  // Usando 'name' en lugar de 'nombre_completo'
                'email' => 'cliente' . $i . '@ejemplo.com',
                'password' => Hash::make('password123'),  // Cambia la contraseña por una segura
                'role' => 'cliente',
            ]);
        }
    }
}
