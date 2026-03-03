<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LogoutRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpMail;

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

    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $otp = rand(100000, 999999);
        $user = User::where('email', $request->email)->first();
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'Code has been sent to your inbox.']);
    }

     public function verifyOtp(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        $user = User::where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('otp_expires_at', '>=', Carbon::now())
        ->first();

        if (!$user) {
            return response()->json(['message' => 'invalid code or expired.'], 422);
        }

        return response()->json(['message' => 'Password Verified.']);
        
        }
        public function resetPassword(Request $request) {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required',
                'password' => 'required|confirmed|min:8',
            ]);
        
            $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>=', Carbon::now())->first();
            

            if (!$user) {
                return response()->json(['message' => 'Invalid code or expired.'], 422);
            }

            $user->update([
                'password' => Hash::make($request->password),
                'otp' => null,
                'otp_expires_at' => null,
            ]);
            return response()->json(['message' => 'Password has been resetted.' ]);
        }
}