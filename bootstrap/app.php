<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    // Incoming requests from SPA can authenticate using session cookies.
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->statefulApi(); 
    $middleware->alias([
     // Defining token alias abilities.
    'abilities' => CheckAbilities::class,
    'ability' => CheckForAnyAbility::class,
    'auth' => Authenticate::class,
    'checkrole' => CheckRole::class
    ]);

})
    ->withMiddleware(function (Middleware $middleware): void {
            //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

   
    
