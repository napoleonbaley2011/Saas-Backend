<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // Mostrar todos los planes
    public function getAllPlans()
    {
        $plans = Plan::all();
        return response()->json($plans);
    }

    // Crear un nuevo plan
    public function createPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $plan = Plan::create($request->all());

        return response()->json(['message' => 'Plan creado exitosamente', 'plan' => $plan], 201);
    }

    // Mostrar un plan específico
    public function getPlan($id)
    {
        $plan = Plan::findOrFail($id);
        return response()->json($plan);
    }

    // Actualizar un plan existente
    public function updatePlan(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update($request->all());

        return response()->json(['message' => 'Plan actualizado exitosamente', 'plan' => $plan]);
    }

    // Eliminar un plan
    public function deletePlan($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return response()->json(['message' => 'Plan eliminado exitosamente']);
    }
}
