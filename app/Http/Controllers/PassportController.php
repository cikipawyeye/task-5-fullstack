<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    public function login(Request $request) {
        $loginCred = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if (!Auth::attempt($loginCred)) {
            $msg = "Invalid Credentials!";
            return response()->json([
                'error' => 'Invalid credentials!',
                'code' => 401
            ], 401);
        }

        $user = Auth::user();
        $accessToken = $user->createToken('accessToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }

}
