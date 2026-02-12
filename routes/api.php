<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use App\Http\Controllers\Resetpasswordcontroller;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;


// Login endpoint om te kunnen inloggen met een bestaand account
Route::post('/login', [AuthController::class,"login"])->name('login');
// Register endpoint voor het registreren van een nieuw account
Route::post('/register', [AuthController::class,"register"])->name('register');
// Password request endpoint voor het aanvragen van een wachtwoord reset

// Wachtwoord reset endpoint voor het resetten van een wachtwoord met een token
Route::post('/password/request', [Resetpasswordcontroller::class,'request']);
Route::post('/password/reset', [Resetpasswordcontroller::class,'reset']);

Route::middleware('auth:sanctum')->group(function () {
    // /me endpoint voor het ophalen van de huidige ingelogde gebruiker
   
    Route::middleware('auth:sanctum')->get('/me', 
    function (Request $request)
     {
        return $request->user();
    });

    // Logout endpoint voor het uitloggen van een ingelogde gebruiker

});

Route::post('/articles', [ArticleController::class,'store']);
    