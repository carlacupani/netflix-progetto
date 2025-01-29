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

class ApiController extends BaseController
{
    // Recupera la lista dei generi dei film
    public function getGenreMovieList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => env('API_BASE_URL') . "/genre/movie/list?language=it",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('API_KEY_AUTH'),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response) {
            return response()->json(json_decode($response));
        } else {
            return response()->json(['error' => 'Errore nel recupero della lista dei generi']);
        }
    }

    // Recupera la lista di film in base ad un parola di ricerca
    public function getSearchMovie(Request $request)
    {
        if(!Session::has('user_id')){
            exit;
        }

        $query = urlencode($request->get("q"));
        $url = env('API_BASE_URL') . "/search/movie?include_adult=false&language=it-IT&page=1&query=" . $query;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('API_KEY_AUTH'),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return $response;
    }

    // Recupera la lista dei dettagli di un determinato film
    public function getDetailsMovie(string $movieId)
    {
        $url = env('API_BASE_URL') . "/movie/{$movieId}?append_to_response=casts,videos,images,releases&language=it-IT";
        
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('API_KEY_AUTH'),
                "accept: application/json"
            ],
        ]);
        
        $response = curl_exec($curl);
        curl_close($curl);
        
        if ($response) {
            return response()->json(json_decode($response));
        } else {
            return response()->json(['error' => 'Errore nel recupero dei dettagli']);
        }
    }

    // Recupera la lista dei film più popolari
    public function getPopularMovieList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => env('API_BASE_URL'). "/movie/popular?language=it-IT&page=1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('API_KEY_AUTH'),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response)
            return $response;
        else
            return $err;
    }

    // Recupera la lista dei film raccomandati in base ad un determinato film
    public function getRecommendationsMovie(Request $request)
    {
        //https://api.themoviedb.org/3/movie/533535/recommendations?api_key=d78d423f56d4447b1dde96e58bf54216&page=1&language=it
        //`https://api.themoviedb.org/3/movie/${movieId}/recommendations?api_key=${api_key}&page=1&language=it`
        $movieId = urlencode($request->get("mid"));
        $url = env('API_BASE_URL') . "/movie/" . $movieId . "/recommendations?language=it-IT&page=1";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('API_KEY_AUTH'),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response)
            return $response;
        else
            return $err;
    }

    // Recupera la lista dei film più valutati
    public function getTopratedMovie()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => env('API_BASE_URL') . "/movie/top_rated?language=it-IT&page=1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . env('API_KEY_AUTH'),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response)
            return $response;
        else
            return $err;
    }

    // Recupera la lista dei film in tendenza
    public function getTrendingMovie() {
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => env('API_BASE_URL') . "/trending/movie/week?language=it-IT&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . env('API_KEY_AUTH'),
            "accept: application/json"
        ],
    ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response)
            return $response;
        else
            return $err;
    }

    // Recupera la lista dei film in uscita
    public function getUpcomingMovie()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL =>  env('API_BASE_URL') . "/movie/upcoming?language=it-IT&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . env('API_KEY_AUTH'),
            "accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($response)
        return $response;
    else
        return $err;
        
    }

    // Recupera frase random di un anime e il suo personaggio
    public function getRandomQuote(){
        $url = 'https://api.gameofthronesquotes.xyz/v1/random';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_errno($ch);

        curl_close($ch);

        if($err) {
            return $err;
        } else {
            $quote = json_decode($response, true);
        }

    }

}