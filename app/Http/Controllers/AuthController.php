<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    
        if (!empty($request->input('email')) && !empty($request->input('password'))) {
            $user = User::where('email', $request->input('email'))->first();
            
            if (!$user) {
                $error['email'] = "Email non trovata";
            } else {
                if (!password_verify($request->input('password'), $user->password)) {
                    $error['password'] = "Password errata";
                }
            }
        } else {
            $error['email'] = "Inserisci email e password";
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
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
    
        $users_row = DB::table('users')->where('email', $email)->count();
    
        if ($users_row > 0) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username'); // Ottieni il nome utente dal corpo della richiesta
    
        // Ottieni le righe degli utenti che corrispondono al nome utente
        $users_row = DB::table('users')->where('username', $username)->count();
    
        // Controlla se la query ha restituito almeno una riga
        if ($users_row > 0) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function registerUser(Request $request) {
        if (Session::has('user_id')) {
            return response()->json(['redirect' => 'home'], 200);
        }
    
        // Logga i dati ricevuti per il debug
        Log::info('Dati ricevuti:', $request->all());
    
        // Ottieni e hash la password
        $password = password_hash($request->input('password'), PASSWORD_BCRYPT);
    
        // Crea un nuovo utente
        $user = new User;
        $user->username = $request->input('username');
        $user->password = $password;
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
    
        // Prova a salvare il nuovo utente
        try {
            $user->save();
        } catch (\Exception $e) {
            Log::error('Errore durante il salvataggio dell\'utente:', ['exception' => $e]);
            return response()->json(['error' => 'Errore durante il salvataggio dell\'utente.'], 500);
        }
    
        // Salva l'ID dell'utente nella sessione
        Session::put('user_id', $user->id);
    
        // Reindirizza l'utente alla home
        return response()->json(['redirect' => 'home'], 200);
    }


    public function loginUser(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
    
        if (!$user) {
            return redirect('login');
        }
    
        if (!password_verify($request->input('password'), $user->password)) {
            return redirect('login');
        }
    
        // Test per verificare se la sessione viene impostata
        Session::put('test_key', 'test_value');
    
        if (Session::get('test_key') !== 'test_value') {
            return redirect('login');
        }
    
        Session::put('user_id', $user->id);
    
        return redirect('home');
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
