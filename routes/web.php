<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;


// Index routes
//Route::get('index', [AuthController::class, 'index'])->name('index');

// Login routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');

// Signup routes
Route::get('signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('signup', [AuthController::class, 'signup'])->name('signup');
Route::get('signup/check/{field}', [AuthController::class, 'check'])->name('signup_check');


// Home routes
Route::get('home', [HomeController::class, 'showHome'])->name('home');
Route::get('/', 'App\Http\Controllers\HomeController@home');

// Api outes
Route::get('genre_movie_list', [ApiController::class, 'getGenreMovieList'])->name('genre_movie_list');
Route::get('search_content', [ApiController::class, 'search_movie'])->name('search_movie');
Route::post('save_movie', [ApiController::class, 'save_movie'])->name('save_movie');

// Profile routes
Route::get('profile', [HomeController::class, 'showProfile'])->name('profile');


// Logout routes
Route::get('logout', function() {
    Session::flush();
    return redirect('index');
});