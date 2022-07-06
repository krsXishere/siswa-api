<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $reponse = [
            'status' => 200,
            'token' => $token,
            'message' => 'Success',
            'user' => $user,
        ];

        return response($reponse, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Gagal Login',
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $reponse = [
            'status' => 200,
            'token' => $token,
            'message' => 'Berhasil Login',
            'user' => $user,
        ];

        return response($reponse, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Berhasi logout',
        ];
    }
}
