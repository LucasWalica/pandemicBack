<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos de registro
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Autenticación del usuario
        Auth::login($user);

        // Generar un token para el usuario usando Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        // Responder con el token de autenticación en formato JSON
        return response()->json([
            'message' => 'User registered successfully.',
            'user'=> $user,
            'token' => $token,
        ], 201); // 201 es el código HTTP para 'Creado'
    }
}
