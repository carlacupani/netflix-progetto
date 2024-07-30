<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Index routes
//Route::get('index', [AuthController::class, 'index'])->name('index');

// Login routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');

// Signup routes
Route::get('signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('signup', [AuthController::class, 'signup'])->name('signup');
Route::get('signup/check/{field}', [AuthController::class, 'check'])->name('signup_check');


//Home routes
Route::get('home', 'App\Http\Controllers\HomeController@home');
Route::get('/', 'App\Http\Controllers\HomeController@home');
Route::get('search_content', 'App\Http\Controllers\HomeController@search_spotify');
Route::get('profile', 'App\Http\Controllers\HomeController@profile');
Route::post('save_song', 'App\Http\Controllers\HomeController@save_song');


// Logout routes
Route::get('logout', function() {
    Session::flush();
    return redirect('index');
});