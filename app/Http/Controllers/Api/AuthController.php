<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'jabatan' => 'required',
            'password' => 'required|min:8'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }


    public function login(Request $request)
    {
        $user = User::where('nip', $request->nip)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => ['Username atau password tidak sesuai']
            ], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'success' => true,
            'nip' => $user->nip,
            'access_token' => $token,
            'token_type' => 'Bearer' 
        ];

        return response($response, 201);
        
    }

    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();

        if($removeToken){
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ]);
        }
    }
}
