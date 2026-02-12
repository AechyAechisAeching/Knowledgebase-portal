<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;

class Resetpasswordcontroller extends Controller
{
    public function request(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        
        $token = Str::random(64);
        
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request['email']],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );
        
        return response()->json([
            'token' => $token
        ]);
    }
    
    public function reset(Request $request) {
        $request->validate([
            'email'=> 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
        
        $record = DB::table('password_reset_tokens')->where('email', $request['email'])->first();
        
        if (!$record) {
            return response()->json(['error' => 'Invalid token'], 403);
        }
        
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['error' => 'Token expired'], 403);
        }
        
        if (!Hash::check($request['token'], $record->token)) {
            return response()->json(['error' => 'Invalid token'], 403);
        }
        
        User::where('email', $request['email'])->update([
            'password' => Hash::make($request['password'])
        ]);
        
        // Delete token after reset
        DB::table('password_reset_tokens')->where('email', $request['email'])->delete();
        
        return response()->json(['message' => 'Password reset successful.']);
    }
    
}