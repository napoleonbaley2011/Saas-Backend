<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Ejecutar las semillas de la base de datos.
     *
     * @return void
     */
    public function run()
    {
        // Crear dos planes predeterminados
        Plan::create([
            'name' => 'Básico',
            'description' => 'Plan básico para pequeñas microempresas con funcionalidades limitadas.',
            'price' => 19.99,
            'status' => 'active', // o 'inactive' dependiendo de lo que desees
        ]);

        Plan::create([
            'name' => 'Premium',
            'description' => 'Plan premium con todas las funcionalidades para microempresas en crecimiento.',
            'price' => 49.99,
            'status' => 'active', // o 'inactive' dependiendo de lo que desees
        ]);
    }
}