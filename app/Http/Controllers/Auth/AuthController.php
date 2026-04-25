<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = Reception::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Username atau password salah.',
                'errors' => [
                    'username' => ['Username atau password salah.']
                ]
            ], 422);
        }

        $request->session()->regenerate();

        $request->session()->put('auth_user', [
            'user_nik'  => $user->user_nik,
            'user_name' => $user->user_name,
            'username'  => $user->username,
            'role'      => $user->role,
        ]);

        return response()->json([
            'message' => 'Login berhasil',
            'redirect' => '/dashboard',
            'user' => [
                'user_nik'  => $user->user_nik,
                'user_name' => $user->user_name,
                'username'  => $user->username,
                'role'      => $user->role,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('auth_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}