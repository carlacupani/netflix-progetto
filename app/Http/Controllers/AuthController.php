<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        if (Session::has('user_id')) {
            return redirect('home');
        }
    
        $error = array();
    
        if (!empty($request->input('username')) && !empty($request->input('password'))) {
            $user = User::where('username', $request->input('username'))->first();
            
            if (!$user) {
                $error['username'] = "Username non trovato";
            } else {
                if (!password_verify($request->input('password'), $user->password)) {
                    $error['password'] = "Password errata";
                }
            }
        } else {
            $error['username'] = "Inserisci username e password";
        }
    
        if (count($error) == 0) {
            Session::put('user_id', $user->id);
            return redirect('home');
        } else {
            return redirect('login')->withInput()->withErrors($error);
        }
    }

    /**
     * Show the signup form.
     */
    public function showSignupForm()
    {
        return view('signup');
    }

    /**
     * Check if the username or email is already taken.
     */
    public function checkEmail($field, Request $request)
    {
        $email = DB::table('users')->where('email',$field)->value('email');
        if (empty($email) || $email == '' || $email == null ) {
            return ['exists' => false];
        }else{
            return ['exists'=> true];
        }
    }

    public function checkUsername($field, Request $request)
    {
        $username = DB::table('users')->where('username',$field)->value('username');
        if (empty($username) || $username == '' || $username == null ) {
            return ['exists' => false];
        }else{
            return ['exists'=> true];
        }
    }


    /**
     * Handle user signup.
     */
    public function signup(Request $request)
    {
        if (Session::has('user_id')) {
            return redirect('home');
        }
    
        $error = array();
    
        // Verifica l'esistenza di dati POST
        if (!empty($request->input("username")) && !empty($request->input("password")) && !empty($request->input('email')) && !empty($request->input('name')) && 
            !empty($request->input('surname')) && !empty($request->input('confirm_password')) && !empty($request->input('allow')))
        {
            # USERNAME
            // Controlla che l'username rispetti il pattern specificato
            if (!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $request->input('username'))) {
                $error['username'] = "Username non valido";
            } else {
                if (User::where('username', $request->input('username'))->first()) {
                    $error['username'] = "Username già utilizzato";
                }
            }
            # PASSWORD
            if (strlen($request->input("password")) < 8) {
                $error['password'] = "Caratteri password insufficienti";
            } 
            # CONFERMA PASSWORD
            if ($request->input('password') != $request->input('confirm_password')) {
                $error['password'] = "Le password non coincidono";
            }
            # EMAIL
            if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Email non valida";
            } else {
                if (User::where('email', $request->input('email'))->first()) {
                    $error['email'] = "Email già utilizzata";
                }
            }
    
            # REGISTRAZIONE NEL DATABASE
            if (count($error) == 0) {
                $password = password_hash($request->input('password'), PASSWORD_BCRYPT);
    
                $user = new User;
                $user->username = $request->input('username');
                $user->password = $password;
                $user->name = $request->input('name');
                $user->surname = $request->input('surname');
                $user->email = $request->input('email');
                $user->save();
    
                Session::put('user_id', $user->id);
                return redirect('home');
            }
        } else {
            $error[] = "Compila tutti i campi";
        }
    
        return redirect('signup')->withInput()->withErrors($error);
    }


}
