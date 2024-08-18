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
Route::get('home', [HomeController::class, 'showHome'])->name('home');
Route::get('trending', [HomeController::class, 'showTrending'])->name('trending');
Route::get('serietv', [HomeController::class, 'showSerietv'])->name('serietv');
Route::get('movie_all', [HomeController::class, 'showMovieall'])->name('movie_all');


// Details page routes
Route::post('delete_movie', [HomeController::class, 'deleteMovie'])->name('delete_movie');
Route::get('details_movie', [HomeController::class, 'showDetailsMovie']);
Route::get('details_serietv', [HomeController::class, 'showDetailsSerietv']);
Route::post('check_movie', [HomeController::class,'checkMovie']);
Route::post('save_movie', [HomeController::class, 'saveMovie']);


// Api film routes
Route::get('genre/movie/list', [ApiController::class, 'getGenreMovieList'])->name('genre_movie_list');
Route::get('search/movie', [ApiController::class, 'getSearchMovie'])->name('search_movie');
Route::get('movie/details', [ApiController::class,'getDetailsMovie'])->name('details_movie');
Route::get('movie/recommendations', [ApiController::class,'getRecommendationsMovie'])->name('recommendations_movie');
Route::get('movie/popular', [ApiController::class,'getPopularMovieList'])->name('popular_movie');
Route::get('movie/top_rated', [ApiController::class,'getTopratedMovie'])->name('toprated_movie');
Route::get('trending/movie/week', [ApiController::class,'getTrendingMovie'])->name('trending_movie');
Route::get('movie/upcoming', [ApiController::class,'getUpcomingMovie'])->name('upcoming_movie');



// Api serietv routes
Route::get('serietv/details', [ApiController::class,'getDetailsSerietv'])->name('serietv_details');
Route::get('serietv/recommendations', [ApiController::class,'getRecommendationsSerietv'])->name('recommendations_serietv');
Route::get('trending/tv/week', [ApiController::class,'getTrendingSerietv'])->name('trending_serietv');
Route::get('serietv/on_the_air', [ApiController::class,'getOntheairSerietv'])->name('ontheair_movie');
Route::get('serietv/top_rated', [ApiController::class,'getTopratedSerietv'])->name('toprated_serietv');
Route::get('serietv/popular', [ApiController::class,'getPopularSerietv'])->name('popular_serietv');
Route::get('genre/serietv/list', [ApiController::class, 'getGenreSerietvList'])->name('genre_serietv_list');
Route::get('search/serietv', [ApiController::class, 'getSearchSerietv'])->name('search_serietv');

// Profile routes
Route::get('user/profile', [HomeController::class, 'showProfile'])->name('profile');
Route::get('', [HomeController::class, 'showEditProfile'])->name('edit_profile');
Route::post('edit_profile', [HomeController::class, 'editProfile'])->name('edit_profile');
Route::get('favorite_movie', [HomeController::class, 'getFavoriteMovie'])->name('favorite_movie');


// Logout routes
Route::get('logout', function() {
    Session::flush();
    return redirect('index');
});
