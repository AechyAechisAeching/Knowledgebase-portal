<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    /*
    1. if bearer token doesn't match, response 'Unauthenticated'
    2. decode and validate the token and finding the user, if not found? response unauthenticated.
    3.  Attaching user request
    */

    if (!$request->bearerToken()) {
        return response()->json(['message' => 'Token not authorized.']);
    }

    $user = User::where('api_token', $request->bearerToken())->first();

    if (!$user) {
        return response()->json(['message' => 'User not authorized.']);
    }

    $request->setUserResolver(callback: fn() => $user);
        return $next($request);
    }
}
