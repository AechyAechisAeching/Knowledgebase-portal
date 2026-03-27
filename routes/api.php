<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/newPassword', [AuthController::class, 'newPassword']);
Route::get('/workspace/invite/accept', [WorkspaceController::class, 'acceptInvite'])
->name('workspace.invite.accept');    

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    //Ziet eigen projecten
    Route::get('projects', [ProjectsController::class, 'myProjects']);
    //Zoekbalk binnen project (titel + content)
    Route::get('/projects/{project}/articles/search', [ArticleController::class, 'search']);
    //Kan artikelen lezen (alleen published)
    Route::get('/projects/{project}/articles/{article}', [ArticleController::class, 'showPublished']);
    //(Optioneel) “Was dit nuttig?” + feedback tekstveld of met emojis
    // Klant: kan alleen lezen binnen eigen klantomgeving + (optioneel) feedback geven.
    Route::post('/articles/{article}/feedback', [ArticleController::class, 'storeFeedback']);
    
    Route::apiResource('articles', ArticleController::class);
    // Route::apiResource('categories', CategoryController::class);
    Route::apiResource('projects', ProjectsController::class);
    // Route::apiResource('workspaces', WorkspaceController::class);
    });


    Route::middleware(['auth:sanctum', 'checkrole:admin'])->prefix('admin')->group(function () {        
        
        /* --------------------------Admin CRUD-------------------------- */
        
        
        // Admin kan alles.

        Route::apiResource('projects', ProjectsController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('articles', ArticleController::class);
        Route::apiResource('workspaces', WorkspaceController::class);
        Route::apiResource('users', UserController::class);
        Route::post('/workspaces/{workspace}/invite', [WorkspaceController::class, 'invite']);
        Route::delete('/workspaces/{workspace}/members/{user}', [WorkspaceController::class, 'removeMember']);
        Route::post('/articles/attachment', [ArticleController::class, 'store']);
    });