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
    #    if (!Session::has('user_id')) {
     #       return redirect('login');
      #  }
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
        if (!Session::has('user_id')) {
            return redirect('login');
        }
        $user = User::find(Session::get('user_id'));
        $movies = $user->movies;
        # parse each content that is a json string
        foreach ($movies as $movie) {
            $movie->content = json_decode($movie->content);
        }
        return view('profile')
            ->with('user', $user)->with('movies', $movies);
    }

    public function editProfile()
    {
    }

    public function showDetails()
    {
        return view('details');
    }
    
    public function saveMovie()
    {
        if (!Session::has('user_id')) {
            return ['ok' => false];
        }

        # skip if the song is already saved by the user
        if (Song::where('song_id', Request::post('id'))->where('user_id', Session::get('user_id'))->first()) {
            return ['ok' => true];
        }

        $song_id = Request::post('id');
        $song_title = Request::post('title');
        $song_artist = Request::post('artist');
        $song_duration = Request::post('duration');
        $song_popularity = Request::post('popularity');
        $song_image = Request::post('image');
        $user_id = Session::get('user_id');

        $song = new Song;
        $song->song_id = $song_id;
        $song->content = json_encode([
            'id' => $song_id,
            'title' => $song_title,
            'artist' => $song_artist,
            'duration' => $song_duration,
            'popularity' => $song_popularity,
            'image' => $song_image
        ]);
        $song->user_id = $user_id;
        $song->save();


        return ['ok' => true];
    }

    public function deleteMovie()
    {
    }

    
}
