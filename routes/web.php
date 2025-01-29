<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;


// Index routes
Route::get('index', [HomeController::class, 'showIndex']);
Route::get('/', [HomeController::class, 'showIndex']);

// Login routes
Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('form/login', [AuthController::class, 'loginUser']);

// Signup routes
Route::get('signup', [AuthController::class, 'showSignupForm']);
Route::post('form/register', [AuthController::class, 'registerUser']);

// check field routes
Route::post('signup/check/username', [AuthController::class, 'checkUsername']);
Route::post('signup/check/email', [AuthController::class, 'checkEmail']);

// Home routes
Route::get('home', [HomeController::class, 'showHome']);
Route::get('movie', [HomeController::class, 'showHome']);

// Details page routes
Route::get('movie/details/{movieId}', [HomeController::class, 'showDetailsMovie']);
Route::post('movie/details/check_movie', [HomeController::class, 'checkMovie']);
Route::post('movie/details/save_movie', [HomeController::class, 'saveMovie']);
Route::post('movie/details/delete_movie', [HomeController::class, 'deleteMovie']);

// Api film routes
Route::get('genre/movie/list', [ApiController::class, 'getGenreMovieList']);
Route::get('search/movie', [ApiController::class, 'getSearchMovie']);
Route::get('movie/details/movie/recommendations', [ApiController::class,'getRecommendationsMovie']);
Route::get('movie/popular', [ApiController::class,'getPopularMovieList']);
Route::get('movie/top_rated', [ApiController::class,'getTopratedMovie']);
Route::get('trending/movie/week', [ApiController::class,'getTrendingMovie']);
Route::get('movie/upcoming', [ApiController::class,'getUpcomingMovie']);

// Profile routes
Route::get('profile', [HomeController::class, 'showProfile']);
Route::get('edit_profile/{id}', [HomeController::class, 'showEditProfile']);
Route::put('edit_profile/{id}', [HomeController::class, 'editProfile']);

// Mia lista routes
Route::get('mialista', [HomeController::class, 'showMiaLista']);
Route::get('favorite_movie', [HomeController::class, 'getFavoriteMovie']);

// Api random quotes from anime
Route::get('random_quote', [ApiController::class, 'getRandomQuote']);

// Logout routes
Route::get('logout', function() {
    Session::flush();
    return redirect('index');
});
