<?php

namespace Database\Seeders;

use App\Models\Microempresa;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MicroempresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener los planes existentes
        $plans = Plan::all();

        // Obtener los usuarios con el rol de microempresa
        $microempresas = User::where('role', 'microempresa')->take(10)->get();  // Toma solo 10 usuarios, puedes ajustar esto

        foreach ($microempresas as $index => $microempresa) {
            // Crear una microempresa asociada a un usuario y un plan
            Microempresa::create([
                'nombre' => 'Microempresa ' . ($index + 1),  // Nombre de la microempresa
                'user_id' => $microempresa->id,  // Relación con el usuario
                'plan_id' => $plans->random()->id,  // Asignar un plan aleatorio de los dos existentes
                'direccion' => 'Dirección de la microempresa ' . ($index + 1),
                'telefono' => '123456789' . $index,  
                'nit' => '6853618' . $index,  // Teléfono ficticio para cada microempresa
                'estado' => 'activa',  // Establecemos que está activa
                'logo' => 'logo_miniempresa' . ($index + 1) . '.png',  // Logo ficticio
                'horario_atencion' => 'Lunes a Viernes, 9 AM - 5 PM',  // Horario ficticio
            ]);
        }
    }
}
