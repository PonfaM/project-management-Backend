<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

    //Register a new user

   $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
                 
        if ($validator ->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }   

        $user = User::create($request->all());

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
        'message' => 'User registered successfully', 
        'user' => $user,
        'token' => $token], 201);
    }


// Login a user API endpoint
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }  
    
    // Logout a user API endpoint
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();          

        return response()->json(['message' => 'User logged out successfully'], 200);
    }
}
