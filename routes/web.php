<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//  Route::get('login', function() {
//      return view('loginpage');
//  })->name('login');

// Route::view('register', 'registerpage')
//     ->middleware('guest')
//     ->name('register');

// Route::post('/register', Register::class)
//     ->middleware('guest');
        
// Route::post('/logout', Logout::class)
//     ->middleware('auth')
//     ->name('logout');