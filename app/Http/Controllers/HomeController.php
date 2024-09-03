<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        if (!Session::has('user_id')) {
            return redirect('login');
        }
        return view('home');
    }
    public function showSerietv()
    {
        return view('serietv');
    }

    public function showProfile()
    {
        if (!Session::has('user_id')) {
            return redirect('login');
        }
        
        $user = User::find(Session::get('user_id'));
        
        if (!$user) {
            return redirect('login');
        }
        
        return view('profile')
            ->with('user', $user);
    }
    
    public function showEditProfile()
    {
        if (!Session::has('user_id')) {
            return redirect('login');
        }
        
        $user = User::find(Session::get('user_id'));
        
        if (!$user) {
            return redirect('login');
        }

        return view('edit_profile')
            ->with('user', $user);;
    }
    public function editProfile(Request $request)
    {

        if (!Session::has('user_id')) {
            return redirect('login');
        }
        
        $user = User::find(Session::get('user_id'));
        
        if (!$user) {
            return redirect('login');
        }
        // Aggiorna i campi dal form
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->username = $request->input('username');
        $user->email = $request->input('email');

        // Gestione della password
        if ($request->filled('new_password')) {
            if ($request->input('new_password') === $request->input('confirm_new_password')) {
                $user->password = bcrypt($request->input('new_password'));
            } else {
                return redirect('edit_profile/'. $user->id)->with('error', 'Le password non coincidono');
            }
        }

        // Salva l'utente aggiornato nel database
        $user->save();

        return redirect('profile')->with('success', 'user updated successfully');

    }

    public function showMiaLista(){
        if (!Session::has('user_id')) {
            return redirect('login');
        }

        $user = User::find(Session::get('user_id'));
        if (!$user) {
            return redirect('login');
        }

        $movies = $user->movies ?? collect();
    
        // Verifica se ci sono film e decodifica il contenuto JSON
        if ($movies->isNotEmpty()) {
            foreach ($movies as $movie) {
                $movie->content = json_decode($movie->content);
            }
        }
        
        // Ritorna la vista del profilo con i dati dell'utente e i film
        return view('mialista')
            ->with('user', $user)
            ->with('movies', $movies);

    }
    public function showDetailsMovie()
    {
        return view('details_movie');
    }
    public function showDetailsSerietv()
    {
        return view('details_serietv');
    }
    
    public function checkMovie(Request $request){

        $movieId = $request->input('movieId');
        $userId = $request->input('userId'); // Corretto qui
    
        // Query per verificare se il film è presente nei preferiti dell'utente
        $result = DB::table('films')
                    ->where('user', $userId)
                    ->whereRaw("JSON_EXTRACT(content, '$.movieId') = ?", [$movieId])
                    ->exists();
    
        // Controlla se ci sono risultati
        if ($result) {
            // Il film è stato aggiunto ai preferiti
            return response()->json(['isFavorited' => true]);
        } else {
            // Il film non è stato aggiunto ai preferiti
            return response()->json(['isFavorited' => false]);
        }
    }

    public function checkSerie(Request $request){

        $serieId = $request->input('serieId');
        $userId = $request->input('userId'); // Corretto qui
    
        // Query per verificare se il film è presente nei preferiti dell'utente
        $result = DB::table('films')
                    ->where('user', $userId)
                    ->whereRaw("JSON_EXTRACT(content, '$.serieId') = ?", [$serieId])
                    ->exists();
    
        // Controlla se ci sono risultati
        if ($result) {
            // Il film è stato aggiunto ai preferiti
            return response()->json(['isFavorited' => true]);
        } else {
            // Il film non è stato aggiunto ai preferiti
            return response()->json(['isFavorited' => false]);
        }
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
            'genre_ids' => $genre_ids,
            'isSerie' => 0
        ]);
        $film->save();

        return ['ok' => true];
        
    }

    public function saveSerie(Request $request)
    {
        if (!Session::has('user_id')) {
            return ['ok' => false];
        }
        
        // Verifica se il film esiste già per l'utente
        $filmEsistente = Movie::where('content->serieId', $request->post('serieId'))
                              ->where('user', Session::get('user_id'))
                              ->first();
        
        if ($filmEsistente) {
            return ['ok' => true];
        }
        
        // Raccogli i dati dal request
        $serieId = $request->post('serieId');
        $name = $request->post('name');
        $first_air_date = $request->post('first_air_date');
        $last_air_date = $request->post('last_air_date');
        $episode_run_time = $request->post('episode_run_time');
        $vote_average = $request->post('vote_average');
        $genres = $request->post('genres');
        $created_by = $request->post('created_by');
        $overview = $request->post('overview');
        $backdrop_path = $request->post('backdrop_path');
        $poster_path = $request->post('poster_path');
        
        $user_id = Session::get('user_id');
        
        // Crea un nuovo record per il film
        $film = new Movie;
        $film->user = $user_id; // Imposta l'ID dell'utente
        $film->content = json_encode([
            'serieId' => $serieId,
            'name' => $name,
            'first_air_date' => $first_air_date,
            'last_air_date' => $last_air_date,
            'episode_run_time' => $episode_run_time,
            'vote_average' => $vote_average,
            'genres' => $genres,
            'created_by' => $created_by,
            'overview' => $overview,
            'backdrop_path' => $backdrop_path,
            'poster_path' => $poster_path,
            'isSerie' => 1
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

        // Esegui la query per trovare i film preferiti dell'utente utilizzando il QueryBuilder
        $films = DB::table('films')
                    ->select('content')
                    ->where('user', $user_id)
                    ->get();

        if(isset($films) && !empty($films)){

            if(count($films) > 1 ){

                foreach ($films as $film) {
                    $filmContent = json_decode($film->content, true);

                    if ($filmContent['isSerie'] == 1) {
                        
                        $responseData[] = [
                            'serieId' => $filmContent['serieId'],
                            'name' => $filmContent['name'],
                            'first_air_date' => $filmContent['first_air_date'],
                            'last_air_date' => $filmContent['last_air_date'],
                            'episode_run_time' => $filmContent['episode_run_time'],
                            'vote_average' => $filmContent['vote_average'],
                            'genres' => $filmContent['genres'],
                            'created_by' => $filmContent['created_by'],
                            'overview' => $filmContent['overview'],
                            'backdrop_path' => $filmContent['backdrop_path'],
                            'poster_path' => $filmContent['poster_path'],
                            'isSerie' => $filmContent['isSerie'],
                        ];
                        
                    }else{

                        $responseData[] = [
                            'movieId' => $filmContent['movieId'],
                            'title' => $filmContent['title'],
                            'release_date' => $filmContent['release_date'],
                            'runtime' => $filmContent['runtime'],
                            'vote_average' => $filmContent['vote_average'],
                            'genres' => $filmContent['genres'],
                            'overview' => $filmContent['overview'],
                            'backdrop_path' => $filmContent['backdrop_path'],
                            'poster_path' => $filmContent['poster_path'],
                            'isSerie' => $filmContent['isSerie'],
                        ];
                    }

                }

            }

        }


        // Restituisci i film in formato JSON
        return response()->json(['ok' => true, 'films' => $responseData]);
    }

    
}
