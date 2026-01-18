<?php

namespace App\Http\Controllers;

use App\Models\Microempresa;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function adminMicroempresas()
    {
        $microempresas = Microempresa::with(['user', 'plan'])->get();

        $microempresas_data = $microempresas->map(function ($microempresa) {
            return [
                'id' => $microempresa->id,
                'nombre_microempresa' => $microempresa->nombre,
                'usuario' => [
                    'name' => $microempresa->user->name,
                    'email' => $microempresa->user->email,
                ],
                'plan' => [
                    'nombre_plan' => $microempresa->plan->name,
                    'descripcion' => $microempresa->plan->description,
                ],
                'direccion' => $microempresa->direccion,
                'telefono' => $microempresa->telefono,
                'nit' => $microempresa->nit,
                'estado' => $microempresa->estado,
                'logo' => $microempresa->logo,
                'horario_atencion' => $microempresa->horario_atencion,
            ];
        });

        // Retornar la respuesta en formato JSON
        return response()->json(['microempresas' => $microempresas_data]);
    }

    public function updateMicroempresaStatus($id)
    {
        logger($id);
        $microempresa = Microempresa::findOrFail($id);

        $microempresa->estado = ($microempresa->estado == 'activa') ? 'inactiva' : 'activa';
        $microempresa->save();

        return response()->json(['message' => 'Estado actualizado correctamente', 'estado' => $microempresa->estado]);
    }

    public function getAllPlans()
    {
        $plans = Plan::all();
        return response()->json($plans);
    }
}
