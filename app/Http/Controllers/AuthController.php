<?php

namespace App\Http\Controllers;
use App\Mail\ForgotMail;
use App\Mail\ResetMail;
use App\Models\password_reset_tokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        $data = $request->validated();

        $user = User::create([
            'name'=> $data['name'],
            'email'=> $data['email'],
            'password'=> Hash::make($data['password']),
            'address' => $data['address'],
            'company' => $data['company'],
            'phone_number' => $data['phone_number']
        ]);
        
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'message' => 'Geregistreerd!',
            'token'=> $token,
            'user'=> $user,
        ]);
    }
   public function login(LoginRequest $request)
{
    $validated = $request->validated();
    
    $credentials = [
        'email' => $validated['email'],
        'password' => $validated['password'],
    ];
    
    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Ongeldige inloggegevens.'], 401);
    }
    
    $user = Auth::user();
    $token = $user->createToken('token-name', ['server:update'])->plainTextToken;
    
    return response()->json([
        'message' => 'Ingelogd!',
        'token' => $token,
        'user' => $user,
    ]);
}

    public function logout(LogoutRequest $request) {

    $user = $request->user();
    if (! $user) {
    return response()->json([
    'success' => false,    
    'message'=> 'Onbevoegd!'],401);
}
    
    $user->currentAccessToken()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Succesvol uitgelogd!'
        ],200);
}

    /* ---------------------------------------------------------------------------------------------------
        ? PASSWORD RESET
    */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Huidige wachtwoord is onjuist.'], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);
        // Email
        Mail::to($user->email)->send(new ResetMail());

        return response()->json(['message' => 'Wachtwoord is gereset.']);
    }

    /* --------------------------------------------------------------------------------------------------- 
        ? PASSWORD FORGET
    */
    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);
        
        $pool = '1234567890QWERTYUIOPASDFGHJKLZXCVBNM';
        $otp = substr(str_shuffle($pool), 0, 6);
        $user = User::where('email', $request->email)->first();

        DB::table('password_reset_tokens')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'token' => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => now(),
            ]
        );
        
        Mail::to($user->email)->send(new OtpMail($otp));
        return response()->json(['message' => 'Een verificatiecode is gestuurd naar jouw mail.']);
        }

     public function verifyOtp(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Not Found.'    
            ], 404);
            
        }
        
        $record = DB::table('password_reset_tokens')
        ->where('user_id', $user->id)
        ->where('expires_at', '>=', Carbon::now())->first();
        
        if (!$record || !Hash::check($request->otp, $record->token)) {
            return response()->json(['message' => 'Onjuist of verlopen.'], 422);
        }
        return response()->json(['message' => 'Code geverifieerd.']);
        }
        public function newPassword(Request $request) {
        $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required',
        'password' => 'required|min:8|confirmed'
        ]);
                                   
       $user = User::where('email', $request->email)->first();
          
                // !DEBUGGING
                // Laat de otp code zien, hoef je niet op je telefoon te kijken
                // var_dump($otp);

        $record = DB::table('password_reset_tokens')
        ->where('user_id', $user->id)
        ->where('expires_at', '>=', Carbon::now())
        ->first();


        if (!$record || !Hash::check($request->otp, $record->token)) {
        return response()->json(['message' => 'Invalid code or expired.'], 422);
         }

        $user->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where('user_id')->delete();
        Mail::to($user->email)->send(new ForgotMail());  
        return response()->json(['message' => 'Je wachtwoord is gereset.']);
           
        }
}