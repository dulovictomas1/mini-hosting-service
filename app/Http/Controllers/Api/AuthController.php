<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ( ! Auth::attempt($validated) ) {
            return response()->json([
                'success' => false,
                'message' => 'Neplatné poverenia',
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }
}