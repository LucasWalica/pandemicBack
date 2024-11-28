<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    

    public function updateProfilePic(Request $request){
        $validated = $request->validate([
            'profilePic' => 'required|string',
        ]);

        $user = Auth::user();

        if(!$user){
            throw ValidationException::withMessages([
                'user' => ['usuario no autenticado'],
            ]);
        }

        $user->profilePic = $validated['profilePic'];
        $user->save();

        return response()->json([
            'message' => 'Foto de perfil actualizada con exito',
            'profilePic' => $validated['profilePic']
        ]);
    }


    public function getProfileData(Request $request){
        $user = Auth::user();
        
        if(!$user){
            throw ValidationException::withMessages([
                'user' => ['usuario no autenticado'],
            ]);
        };

        $profileData = [	
            'name' => $user->name, 		
            'puntuacion' => $user->puntuacion, 	
            'profilePic' => $user->profilePic,	
        ];

        return response()->json($profileData);
    }
}