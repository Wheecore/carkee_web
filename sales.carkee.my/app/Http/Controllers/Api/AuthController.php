<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $data['token'] = $user->createToken('token-name')->plainTextToken;
            $data['role'] = $user->role_id;
            $data['id'] = $user->id;
            $data['name'] = $user->name;
            return response()->json($data);
        }
    
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        request()->user()->tokens()->delete();
        auth('web')->logout();
        return response()->json(['message' => 'Logged out']);
    }
}
