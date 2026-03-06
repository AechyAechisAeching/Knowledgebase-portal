<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use App\Http\Controllers\UserController;

// Login endpoint om te kunnen inloggen met een bestaand account
Route::post('/login', [AuthController::class,"login"])->name('login');
// Register endpoint voor het registreren van een nieuw account
Route::post('/register', [AuthController::class,"register"])->name('register');
// Password request endpoint voor het aanvragen van een wachtwoord reset


Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
// Wachtwoord reset endpoint voor het resetten van een wachtwoord met een token
Route::post('/newPassword', [AuthController::class, 'newPassword']);


Route::middleware('auth:sanctum')->group(function () {
    // /me endpoint voor het ophalen van de huidige ingelogde gebruiker
    Route::get('/me', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Project & Articles

    //  Endpoint voor Projecten & Articles
    Route::get('/projects', [ProjectsController::class, 'index']);
    Route::get('projects', [ProjectsController::class, 'myProjects']);
    Route::get('/projects/{project}/articles', [ArticleController::class, 'projectArticles']);
    Route::apiResource('projects', ProjectsController::class)->except(['index']);
    
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    
        // Attachments: article_id, mime, original_name, size, path
    Route::post('/articles/attachment', [ArticleController::class, 'storeAttachment']);

    });

    Route::middleware(['auth:sanctum', 'checkrole:admin'])->prefix('admin')->group(function() {
        //  Protected routes
    Route::get('/test', function() {
        return response()->json(['message' => 'admin.']);
    });
    Route::get('/dashboard', [DashboardController::class, 'index']);


        /* --------------------------Admin CRUD-------------------------- */

         // Projects CRUD

         Route::get('/projects', [ProjectsController::class, 'AdminIndex']);
         Route::get('/projects/{project}', [ProjectsController::class, 'show']);
         Route::post('/projects', [ProjectsController::class, 'store']);
         Route::get('projects', [ProjectsController::class, 'myProjects']); 
         Route::put('/projects/{project}', [ProjectsController::class, 'update']);
         Route::delete('/projects/{project}', [ProjectsController::class, 'destroy']);

         // Categories CRUD

         Route::get('/categories', [CategoryController::class, 'AdminIndex']);
         Route::get('/categories/{category}', [CategoryController::class, 'show']);
         Route::post('/categories', [CategoryController::class, 'store']);
         Route::put('/categories/{category}', [CategoryController::class, 'update']);
         Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

         // Articles CRUD
         Route::get('/articles', [ArticleController::class, 'AdminIndex']);
         Route::get('/articles/{article}', [ArticleController::class, 'show']);
         Route::post('/articles', [ArticleController::class, 'store']);
         Route::put('/articles/{article}', [ArticleController::class, 'update']);
         Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
         

         // Admin User CRUD
         Route::get('/users/{id}', fn($id) => response()->json(User::findOrFail($id)));
         Route::post('/users', [UserController::class, 'store']);
         Route::put('/users/{id}', [UserController::class, 'update']);
         Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });