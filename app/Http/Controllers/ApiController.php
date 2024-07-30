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

    public function getGenreMovieList()
    {
        $config = [
            'api_base_url' => env('API_BASE_URL'),
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

    public function search_movie()
    {
        $config = [
            'api_base_url' => env('API_BASE_URL'),
            'api_key_auth' => env('API_KEY_AUTH'),
        ];
        $curl = curl_init();

    }

    public function save_movie()
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
}
