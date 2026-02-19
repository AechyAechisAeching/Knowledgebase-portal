<?php

namespace App\Http\Controllers;
use AddressInfo;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LogoutRequest;
use Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function register(RegisterRequest $request) {
        $validated = $request->validated();

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password'=> 'required',
        'address' => 'nullable|string',
        'company' => 'nullable',
        'phone_number' => 'nullable|string|max:15',
        ]);

        $user = User::create([
            'name'=> $validated['name'],
            'email'=> $validated['email'],
            'password'=> Hash::make($validated['password']),
            'address' => $validated['address'],
            'company' => $validated['company'],
            'phone_number' => $validated['phone_number']
        ]);

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'message' => 'User Registered',
            'token'=> $token,
            'user'=> $user,
        ]);
    }
   public function login(LoginRequest $request)
{
    $validated = $request->validated();
    
    // Extract only email and password for authentication
    $credentials = [
        'email' => $validated['email'],
        'password' => $validated['password'],
    ];
    
    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    
    $user = Auth::user();
    $token = $user->createToken('token-name', ['server:update'])->plainTextToken;
    
    return response()->json([
        'message' => 'User Logged in',
        'token' => $token,
        'user' => $user,
    ]);
}

public function logout(LogoutRequest $request) {

$user = $request->user();
if (! $user) {
    return response()->json([
    'success' => false,    
    'message'=> 'Unauthorized'],401);
}
    
    $user->currentAccessToken()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Successfully logged out your account!'
        ],200);
}

    }