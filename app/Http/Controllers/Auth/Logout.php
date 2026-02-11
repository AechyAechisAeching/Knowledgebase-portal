<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Logout extends Controller
{
    public function __invoke(Request $request)
    {
        // 1. User logs out
        Auth::logout();
        // Gets the session
        // 2.Regenerates the ID
        $request->session()->invalidate();
        // 3. Regenerates the CSRF token
        $request->session()->regenerateToken();
        // 4. Redirects back to index, user needs to log in again.
        return redirect('/')->with('success', 'Logged out.');
        } // request
} // controller