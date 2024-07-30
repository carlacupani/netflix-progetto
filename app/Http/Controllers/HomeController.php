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
public function showHome()
{
    if(!Session::has('user_id')){
        return redirect('login');
    }
return view('home');

}

public function showProfile()
{
    if(!Session::has('user_id')){
        return redirect('login');
    }
    $user = User::find(Session::get('user_id'));
    $movies = $user->movies;
    # parse each content that is a json string
    foreach($movies as $movie) {
        $movie->content = json_decode($movie->content);
    }
    return view('profile')
        ->with('user', $user)->with('movies', $movies);
}

public function editProfile(){}


}