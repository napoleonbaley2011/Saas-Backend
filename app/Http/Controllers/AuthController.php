<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function registerUsers(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'carnet_identidad' => 'required|string|max:20|unique:users',
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:users',  // Verificación de unicidad del email
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Si la validación falla
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear el nuevo usuario
        $user = User::create([
            'carnet_identidad' => $request->carnet_identidad,
            'name' => $request->nombre_completo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role_id,  // Asignar el rol desde la petición
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        logger($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        try {

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = JWTAuth::user();

        $roles = $user->roles;

        $permissions = $roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        });

        return response()->json([
            'message' => 'Inicio sesión exitoso',
            'token' => $token,
            'role' => $user->role,
            'id_user'=>$user->id,
            'user' => [
                'nombre_completo' => $user->name,
                'permissions' => $permissions,
            ],
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = JWTAuth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'La contraseña actual no es correcta'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Contraseña actualizada correctamente'
        ]);
    }

    public function logout(Request $request)
    {
        try {
            // Invalidar el token actual
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Sesión cerrada exitosamente']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo cerrar la sesión'], 500);
        }
    }
}
