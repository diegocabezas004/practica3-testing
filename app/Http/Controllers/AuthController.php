<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();
            $token = $user->createToken('token-name');
            return response()->json([
                'message' => 'Login successful',
                'token' => $token->plainTextToken,
                'user' => Auth::user(),
                ]);
        }
        return response()->json([
            'message' => 'Email o contraseña incorrectos'
        ], 422);
    }

}
