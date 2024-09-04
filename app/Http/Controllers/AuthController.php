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
    // Mostra la pagina di login
    public function showLoginForm()
    {
        return view('login');
    }

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

    // Mostra la pagina di registrazione
    public function showSignupForm()
    {
        return view('signup');
    }

    // Controlla se email e username sono già presi
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

        $errors = [];

        if (!empty($request->input("username")) && !empty($request->input("password")) && !empty($request->input("email")) && !empty($request->input("name")) && 
            !empty($request->input("surname")) && !empty($request->input("confirm_password")))
        {
            # USERNAME
            if (!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $request->input('username'))) {
                $errors[] = 'Lo username è obbligatorio e deve essere una stringa di massimo 255 caratteri.';
            } else {
                if (User::where('username', $request->input('username'))->first()) {
                    $errors[] = 'Questo username è già stato preso.';
                }
            }
    
            # PASSWORD
            if (strlen($request->input("password")) < 8) {
                $errors[] = 'Questa password non è valida.';
            } 
    
            # CONFERMA PASSWORD
            if ($request->input('password') != $request->input('confirm_password')) {
                $errors[] = 'Le password non coincidono.';
            }
    
            # EMAIL
            if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'L\'email è obbligatoria e deve essere un\'email valida';
            } else {
                if (User::where('email', $request->input('email'))->first()) {
                    $errors[] = 'Questa email è già stata presa.';
                }
            }
        }
    
        // Se ci sono errori, reindirizza alla pagina di registrazione con gli errori e i dati inseriti
        if (!empty($error)) {
            return redirect('signup')
                ->withInput()  // Ritorna i dati inseriti
                ->withErrors($error);  // Ritorna gli errori
        }
    
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


}
