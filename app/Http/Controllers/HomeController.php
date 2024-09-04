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
    public function editProfile(Request $request){
        if (!Session::has('user_id')) {
            return redirect('login');
        }
    
        $user = User::find(Session::get('user_id'));
        
        if (!$user) {
            return redirect('login');
        }
  
        $errors = [];

        if (empty($request->input('name')) || !is_string($request->input('name')) || strlen($request->input('name')) > 255) {
            $errors[] = 'Il nome è obbligatorio e deve essere una stringa di massimo 255 caratteri.';
        }
    
        if (empty($request->input('surname')) || !is_string($request->input('surname')) || strlen($request->input('surname')) > 255) {
            $errors[] = 'Il cognome è obbligatorio e deve essere una stringa di massimo 255 caratteri.';
        }
    
        if (empty($request->input('username')) || !is_string($request->input('username')) || strlen($request->input('username')) > 255) {
            $errors[] = 'Lo username è obbligatorio e deve essere una stringa di massimo 255 caratteri.';
        } elseif (User::where('username', $request->input('username'))->where('id', '!=', $user->id)->exists()) {
            $errors[] = 'Questo username è già stato preso.';
        }
    
        if (empty($request->input('email')) || !filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) || strlen($request->input('email')) > 255) {
            $errors[] = 'L\'email è obbligatoria e deve essere un\'email valida';
        } elseif (User::where('email', $request->input('email'))->where('id', '!=', $user->id)->exists()) {
            $errors[] = 'Questa email è già stata presa.';
        }
    
        if ($request->filled('new_password')) {
            if (strlen($request->input('new_password')) < 8) {
                $errors[] = 'La nuova password deve essere di almeno 8 caratteri.';
            }
            if ($request->input('new_password') !== $request->input('confirm_new_password')) {
                $errors[] = 'Le password non coincidono.';
            }
        }

        if (!empty($errors)) {
            return redirect('edit_profile/'. $user->id)
            ->withErrors($errors);
        }
    
        try {
            $user->name = $request->input('name');
            $user->surname = $request->input('surname');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
    
            if ($request->filled('new_password')) {
                $user->password = bcrypt($request->input('new_password'));
            }
   
            $user->save();
  
            return redirect('profile')->with('success', 'I tuoi dati sono stati aggiornati correttamente!');
        } catch (\Exception $e) {
            return redirect('edit_profile/'. $user->id)->with('error', 'Si è verificato un errore durante l\'aggiornamento del profilo: ' . $e->getMessage());
        }
    }
    

    public function showMiaLista(){
        if (!Session::has('user_id')) {
            return redirect('login');
        }

        $user = User::find(Session::get('user_id'));
        if (!$user) {
            return redirect('login');
        }

        $movies = $user->movies ?? collect(); //dubbio
    
        if ($movies->isNotEmpty()) {
            foreach ($movies as $movie) {
                $movie->content = json_decode($movie->content);
            }
        }
        
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
    
        $result = DB::table('films')
                    ->where('user', $userId)
                    ->whereRaw("JSON_EXTRACT(content, '$.movieId') = ?", [$movieId])
                    ->exists();
    
        if ($result) {
            return response()->json(['isFavorited' => true]);
        } else {
            return response()->json(['isFavorited' => false]);
        }
    }

    public function checkSerie(Request $request){

        $serieId = $request->input('serieId');
        $userId = $request->input('userId'); // Corretto qui
    
        $result = DB::table('films')
                    ->where('user', $userId)
                    ->whereRaw("JSON_EXTRACT(content, '$.serieId') = ?", [$serieId])
                    ->exists();
    
        if ($result) {
            return response()->json(['isFavorited' => true]);
        } else {
            return response()->json(['isFavorited' => false]);
        }
    }
    

    public function saveMovie(Request $request)
    {
        if (!Session::has('user_id')) {
            return ['ok' => false];
        }
        
        $filmEsistente = Movie::where('content->movieId', $request->post('movieId'))
                              ->where('user', Session::get('user_id'))
                              ->first();
        
        if ($filmEsistente) {
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
        
        $filmEsistente = Movie::where('content->serieId', $request->post('serieId'))
                              ->where('user', Session::get('user_id'))
                              ->first();
        
        if ($filmEsistente) {
            return ['ok' => true];
        }
        
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

        $user_id = Session::get('user_id');

        $movieId = $request->post('movieId');

        $filmEsistente = Movie::where('content->movieId', $movieId)
            ->where('user', $user_id)
            ->first();

        if ($filmEsistente) {
            $filmEsistente->delete();
            return ['ok' => true];
        }

        return ['ok' => false];
    }

    public function getFavoriteMovie(Request $request)
    {

        if (!Session::has('user_id')) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 401);
        }

        $user_id = Session::get('user_id');

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

        return response()->json(['ok' => true, 'films' => $responseData]);
    }

    
}
