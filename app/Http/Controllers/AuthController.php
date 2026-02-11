<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(RegisterRequest $request) {

    $request->validate([
        'name'> 'required|string',
        'email' => 'required|email|unique:users',
        'password'=> 'required',
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
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
    // Validating the credentials
    $credentials = $request->validated();

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();
    
    $token = $user->createToken('token-name', ['server:update'])->plainTextToken;

    return response()->json([
        'message'=> 'User Logged in',
        'token' => $token,
        'user' => $user,
    
    ]);
    }

    }