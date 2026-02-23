<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {   
        /*
        1. If user request doesnt match required parameter role return
        2. Role isn't admin? response forbidden (403)
        */

        if ($request->user()->role !== $role)
             return response()->json(['message' => 'Forbidden', 403]);

        return $next($request);
    }
}
