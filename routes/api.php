<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Resetpasswordcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Policies\UserPolicy;

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
    Route::middleware('auth:sanctum')->post
    ('/logout', [AuthController::class, 'logout']);

    // Project & Articles

    //  Endpoint voor Projecten & Articles
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']);

    Route::post('/projects', [ProjectsController::class, 'store']);
    Route::get('/projects/{project}', [ProjectsController::class, 'show']);
    

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('projects', ProjectsController::class);
    });
    /**
     * Store an attachment for an article
     */

    // Attachments: article_id, mime, original_name, size, path
    Route::post('/articles/attachment', [ArticleController::class, 'storeAttachment']);

    Route::middleware(['auth:sanctum', 'checkrole:admin'])->prefix('admin')->group(function() {
        //  Protected routes
    Route::get('/test', function() {
        return response()->json(['message' => 'admin.']);
    });


     Route::middleware('auth:sanctum')->get('/users/{id}', function ($id) {
        $user = User::findOrFail($id);
        return response()->json($user);
    });

    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::middleware('auth:sanctum')->post('/users', function (Request $request) {
            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'company' => $request->company,
            'phone_number' => $request->phone_number,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            ]);
            return response()->json(['message' => $user, 201]);
    });
    Route::match(['put', 'patch'], '/users/{id}', function (Request $request, $id) {
        $user = User::findOrFail($id);
        
        $user->update($request->only([
            'name',
            'email',
            'password',
            'address',
            'company',
            'phone_number',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return response()->json($user);

    });



    
    Route::get('/dashboard', [DashboardController::class, 'index']);

    });