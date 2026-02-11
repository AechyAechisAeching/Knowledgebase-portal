<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Login endpoint om te kunnen inloggen met een bestaand account
Route::post("/login", [AuthController::class,"login"])->name("login");

// Register endpoint voor het registreren van een nieuw account
Route::post("/register", [AuthController::class,"register"])->name("register");
// Password request endpoint voor het aanvragen van een wachtwoord reset
Route::post("/resetpassword", [AuthController::class, "resetpassword"])->name("resetpassword");
// Wachtwoord reset endpoint voor het reseten van een wachtwoord met een token

Route::middleware('auth:sanctum')->group(function () {
    // /me endpoint voor het ophalen van de huidige ingelogde gebruiker

    // Logout endpoint voor het uitloggen van een ingelogde gebruiker

});

Route::post('/articles', [AuthController::class,'store']);
    