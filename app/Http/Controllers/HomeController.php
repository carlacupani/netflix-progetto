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
    public function showSerietv()
    {
        return view('serietv');
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
        
        // Verifica se il film esiste già per l'utente
        $filmEsistente = Movie::where('content->movieId', $request->post('movieId'))
                              ->where('user', Session::get('user_id'))
                              ->first();
        
        if ($filmEsistente) {
            return ['ok' => true];
        }
        
        // Raccogli i dati dal request
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
        
        // Crea un nuovo record per il film
        $film = new Movie;
        $film->user = $user_id; // Imposta l'ID dell'utente
        $film->content = json_encode([
            'movieId' => $movieId,
            'title' => $title,
            'release_date' => $release_date,
            'runtime' => $runtime,
            'vote_average' => $vote_average,
            'genres' => $genres,
            'overview' => $overview,
            'backdrop_path' => $backdrop_path,
            'poster_path' => $poster_path,
            'genre_ids' => $genre_ids
        ]);
        $film->save();

        return ['ok' => true];
        
    }

    public function deleteMovie(Request $request)
    {
        if (!Session::has('user_id')) {
            return ['ok' => false];
        }

        // Recupera l'ID dell'utente dalla sessione
        $user_id = Session::get('user_id');

        // Recupera l'ID del film dalla richiesta
        $movieId = $request->post('movieId');

        // Verifica se il film esiste per l'utente
        $filmEsistente = Movie::where('content->movieId', $movieId)
            ->where('user', $user_id)
            ->first();

        if ($filmEsistente) {
            // Elimina il film se esiste
            $filmEsistente->delete();
            return ['ok' => true];
        }

        return ['ok' => false];
    }

    public function getFavoriteMovie(Request $request)
    {
        // Verifica se l'ID utente è presente nella sessione
        if (!Session::has('user_id')) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 401);
        }

        // Recupera l'ID dell'utente dalla sessione
        $user_id = Session::get('user_id');

        // Esegui la query per trovare i film preferiti dell'utente
        $films = Movie::where('user_id', $user_id)->get();

        // Restituisci i film in formato JSON
        return response()->json(['ok' => true, 'films' => $films]);
    }

    
}
