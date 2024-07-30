<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;


// Index routes
Route::get('index', [HomeController::class, 'showIndex'])->name('index');
Route::get('/', [HomeController::class, 'showIndex'])->name('index');

// Login routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');

// Signup routes
Route::get('signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('signup', [AuthController::class, 'signup'])->name('signup');
Route::get('signup/check/{field}', [AuthController::class, 'check'])->name('signup_check');

// Home routes
Route::get('home', [HomeController::class, 'showHome'])->name('home');
Route::post('save_movie', [HomeController::class, 'saveMovie'])->name('save_movie');
Route::post('delete_movie', [HomeController::class, 'deleteMovie'])->name('delete_movie');

// Api routes
Route::get('genre/movie/list', [ApiController::class, 'getGenreMovieList'])->name('genre_movie_list');
Route::get('search/movie', [ApiController::class, 'getSearchMovie'])->name('search_movie');
Route::get('movie/details', [ApiController::class,'getDetailsMovie'])->name('details_movie');
Route::get('movie/recommendations', [ApiController::class,'getRecommendationsMovie'])->name('recommendations_movie');
Route::get('movie/popular', [ApiController::class,'getPopularMovieList'])->name('popular_movie');
Route::get('movie/top_rated', [ApiController::class,'getTopratedMovie'])->name('toprated_movie');
Route::get('trending/movie/week', [ApiController::class,'getTrendingMovie'])->name('trending_movie');
Route::get('movie/upcoming', [ApiController::class,'getUpcomingMovie'])->name('upcoming_movie');


// Profile routes
Route::get('profile', [HomeController::class, 'showProfile'])->name('profile');
Route::post('edit_profile', [HomeController::class, 'editProfile'])->name('edit_profile');

// Logout routes
Route::get('logout', function() {
    Session::flush();
    return redirect('index');
});