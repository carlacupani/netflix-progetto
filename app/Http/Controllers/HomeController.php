<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Movie;

class HomeController extends BaseController
{
    public function showIndex()
    {
        return view('index');
    }
    
    public function showHome()
    {
       # if (!Session::has('user_id')) {
        #    return redirect('login');
       # }
        return view('home');
    }
    public function showTrending()
    {
        return view('trending');
    }
    public function showSerietv()
    {
        return view('serietv');
    }
    public function showMovieall()
    {
        return view('movie_all');
    }

    public function showProfile()
    {
        /**if (!Session::has('user_id')) {
            return redirect('login');
        }
        $user = User::find(Session::get('user_id'));
        $movies = $user->movies;
        # parse each content that is a json string
        foreach ($movies as $movie) {
            $movie->content = json_decode($movie->content);
        }
        return view('profile')
            ->with('user', $user)->with('movies', $movies); */
            return view('profile');
    }

    public function showEditProfile()
    {
        return view('edit_profile');
    }
    public function editProfile()
    {
    }

    public function showDetailsMovie()
    {
        return view('details_movie');
    }
    public function showDetailsSerietv()
    {
        return view('details_serietv');
    }
    
    public function saveMovie(Request $request)
    {
        if (!Session::has('user_id')) {
            return ['ok' => false];
        }

        if (Movie::where('movie_id', $request->post('id'))->where('user_id', Session::get('user_id'))->first()) {
            return ['ok' => true];
        }

        $movieId = $request->post('movieId');
        $title = $request->post('title');
        $release_date = $request->post('release_date');
        $runtime = $request->post('runtime');
        $vote_average = $request->post('vote_average');
        $genres = $request->post('genres');
        $overview = $request->post('overview');
        $backdrop_path = $request->post('backdrop_path');
        $poster_path = $request->post('poster_path');
        $genre_ids = $request->post('genre_ids');
        
        $user_id = Session::get('user_id');

        $movie = new Movie;
        $movie->movie_id = $movieId;
        $movie->content = json_encode([
            'movieId', $movieId,
            'title', $title,
            'release_date', $release_date,
            'runtime', $runtime,
            'vote_average', $vote_average,
            'genres', $genres,
            'overview', $overview,
            'backdrop_path', $backdrop_path,
            'poster_path', $poster_path,
            'genre_ids', $genre_ids
        ]);
        $movie->user_id = $user_id;
        $movie->save();


        return ['ok' => true];
    }

    public function deleteMovie()
    {
    }

    
}
