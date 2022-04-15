<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'user' => $user,
                'token' => $token], 200);
        } else {
            return response()->json(['error' => 'Usuario o clave incorrectos'], 401);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('MyApp')->accessToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        Auth::user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}
