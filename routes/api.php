<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Project & Articles
    // Workspace Area

    // Workspace Routes CRUD
    Route::get('/workspaces', [WorkspaceController::class, 'index']);
    Route::post('/workspaces', [WorkspaceController::class, 'store']);
    Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show']);
    Route::put('/workspaces/{workspace}', [WorkspaceController::class, 'update']);
    Route::delete('/workspaces/{workspace}', [WorkspaceController::class, 'destroy']);
    
    Route::post('/workspaces/{workspace}/invite', [WorkspaceController::class, 'invite']);
    Route::delete('/workspaces/{workspace}/members/{user}', [WorkspaceController::class, 'removeMember']);
    Route::delete('/workspaces/{members}', [WorkspaceController::class, 'destroy']);
    Route::get('/workspaces/{workspace}/articles', [WorkspaceController::class, 'WorkspaceArticles']);    
    Route::get('/workspaces/{workspace}/projects', [WorkspaceController::class, 'WorkspaceProjects']);
    Route::apiResource('projects', ProjectsController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::post('/articles/attachment', [ArticleController::class, 'storeAttachment']);
});


Route::middleware(['auth:sanctum', 'checkrole:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/test', function () {
            return response()->json(['message' => 'admin.']);
        });

        Route::get('/dashboard', [DashboardController::class, 'index']);
        /* --------------------------Admin CRUD-------------------------- */

        // Projects CRUD
        Route::apiResource('projects', ProjectsController::class);
        // Route::get('/projects', [ProjectsController::class, 'AdminIndex']);
        // Route::get('/projects/{project}', [ProjectsController::class, 'show']);
        // Route::post('/projects', [ProjectsController::class, 'store']);
        // Route::get('projects', [ProjectsController::class, 'myProjects']);
        // Route::put('/projects/{project}', [ProjectsController::class, 'update']);
        // Route::delete('/projects/{project}', [ProjectsController::class, 'destroy']);

        // Categories CRUD
        Route::apiResource('categories', CategoryController::class);
        // Route::get('/categories', [CategoryController::class, 'AdminIndex']);
        // Route::get('/categories/{category}', [CategoryController::class, 'show',]);
        // Route::post('/categories', [CategoryController::class, 'store']);
        // Route::put('/categories/{category}', [CategoryController::class,'update']);
        // Route::delete('/categories/{category}', [CategoryController::class, 'destroy',]);

        // Articles CRUD
        Route::apiResource('articles', ArticleController::class);
        // Route::get('/articles', [ArticleController::class, 'AdminIndex']);
        // Route::get('/articles/{article}', [ArticleController::class, 'show']);
        // Route::post('/articles', [ArticleController::class, 'store']);
        // Route::put('/articles/{article}', [ArticleController::class, 'update']);
        // Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

        // Admin User CRUD
        Route::get('/users/{id}',fn($id) => response()->json(User::findOrFail($id)));
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });





    