<?php

namespace App\Http\Controllers;

use App\Models\Microempresa;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MicroempresaController extends Controller
{
    public function create(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'required|string|max:15',
            'plan_id' => 'required|exists:plans,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'horario_atencion' => 'nullable|string',
        ]);

        // Obtener el user_id desde la solicitud
        $userId = $request->user_id;

        // Verificar si el usuario existe
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        // Verificar si el usuario tiene el rol de microempresa
        $roles = $user->roles; // Obtener los roles del usuario desde la relación
        $isMicroempresa = $roles->contains(function ($role) {
            return $role->name === 'microempresa';
        });

        if (!$isMicroempresa) {
            return response()->json(['error' => 'El usuario no tiene el rol de microempresa.'], 403);
        }

        // Manejar la subida del logotipo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public'); // Guardar el logo en el disco público
        }

        // Crear la microempresa
        $microempresa = Microempresa::create([
            'nombre' => $request->nombre,
            'user_id' => $userId,
            'plan_id' => $request->plan_id,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'estado' => 'activa',
            'logo' => $logoPath,  // Guardar la ruta del logo
            'horario_atencion' => $request->horario_atencion, // Guardar el horario de atención
        ]);

        return response()->json(['message' => 'Microempresa creada exitosamente', 'microempresa' => $microempresa], 201);
    }
    // Editar una microempresa existente
    public function edit(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'user_id' => 'required|exists:users,id',  // Verificar que el user_id exista
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'required|string|max:15',
            'plan_id' => 'required|exists:plans,id',  // Asegurarse de que el plan exista
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación del logotipo
            'horario_atencion' => 'nullable|string', // Horario de atención
        ]);

        // Obtener el user_id desde la solicitud
        $userId = $request->user_id;

        // Verificar si el usuario existe
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        // Verificar si el usuario tiene el rol de microempresa
        $roles = $user->roles; // Obtener los roles del usuario desde la relación
        $isMicroempresa = $roles->contains(function ($role) {
            return $role->name === 'microempresa';
        });

        if (!$isMicroempresa) {
            return response()->json(['error' => 'El usuario no tiene el rol de microempresa.'], 403);
        }

        // Encontrar la microempresa
        $microempresa = Microempresa::findOrFail($id);

        // Verificar que el usuario tenga permiso para editar la microempresa
        if ($microempresa->user_id !== $userId) {
            return response()->json(['error' => 'No tienes permiso para editar esta microempresa.'], 403);
        }

        // Manejar la subida del logotipo
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($microempresa->logo) {
                Storage::delete('public/' . $microempresa->logo);
            }

            // Subir el nuevo logo
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            // Mantener el logo actual si no se ha enviado uno nuevo
            $logoPath = $microempresa->logo;
        }

        // Actualizar la microempresa
        $microempresa->update([
            'nombre' => $request->nombre,
            'plan_id' => $request->plan_id,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'logo' => $logoPath,  // Actualizar la ruta del logo
            'horario_atencion' => $request->horario_atencion, // Actualizar el horario de atención
        ]);

        return response()->json(['message' => 'Microempresa actualizada exitosamente', 'microempresa' => $microempresa]);
    }

    public function getAllMicroempresas()
    {
        $microempresas = Microempresa::where('estado', 'activa')->get();

        return response()->json(['microempresas' => $microempresas]);
    }
}
