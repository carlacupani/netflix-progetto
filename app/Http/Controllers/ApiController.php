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
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $config['api_base_url'] . "/genre/movie/list?language=it",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $config['api_key_auth'],
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    // Recupera la lista di film in base ad un parola di ricerca
    public function getSearchMovie()
    {
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        $query = urlencode(Request::get("q"));
        $url = $config['api_base_url'] . "/search/movie?include_adult=false&language=it-IT&page=1&query=" . $query;

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
                "Authorization: Bearer " . $config['api_key_auth'],
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    // Recupera la lista dei dettagli di un determinato film
    public function getDetailsMovie()
    {
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        //`https://api.themoviedb.org/3/movie/${movieId}?api_key=${api_key}&append_to_response=casts,videos,images,releases&language=it`,
        $movieId = urlencode(Request::get("q"));
        $url = $config['api_base_url'] . "/movie/" . $movieId . "?append_to_response=casts,videos,images,releases&language=it-IT";

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
                "Authorization: Bearer " . $config['api_key_auth'],
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    // Recupera la lista dei film più popolari
    public function getPopularMovieList()
    {
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $config['api_base_url'] . "/movie/popular?language=it-IT&page=1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $config['api_key_auth'],
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    // Recupera la lista dei film raccomandati in base ad un determinato film
    public function getRecommendationsMovie()
    {
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        //https://api.themoviedb.org/3/movie/533535/recommendations?api_key=d78d423f56d4447b1dde96e58bf54216&page=1&language=it
        //`https://api.themoviedb.org/3/movie/${movieId}/recommendations?api_key=${api_key}&page=1&language=it`
        $movieId = urlencode(Request::get("mid"));
        $url = $config['api_base_url'] . "/movie/" . $movieId . "/recommendations?language=it-IT&page=1";

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
                "Authorization: Bearer " . $config['api_key_auth'],
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    // Recupera la lista dei film più valutati
    public function getTopratedMovie(){
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $config['api_base_url'] . "/movie/top_rated?language=it-IT&page=1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $config['api_key_auth'],
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function getTrendingMovie(){
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $config['api_base_url'] . "/trending/movie/week?language=it-IT&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $config['api_key_auth'],
            "accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
    }

    public function getUpcomingMovie(){
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_image_base_url' => env('API_IMAGE_BASE_URL'),
            'api_key' => env('API_KEY'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL =>  $config['api_base_url'] . "/movie/upcoming?language=it-IT&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $config['api_key_auth'] ,
            "accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
    }


}