<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        if (Auth::check()) {
            return redirect('home');
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'username' => 'Le credenziali non corrispondono ai nostri record.',
        ])->onlyInput('username');
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
    public function check(Request $request, $field)
    {
        if (empty($request->query('q')) || !in_array($field, ['username', 'email'])) {
            return response()->json(['exists' => false]);
        }

        $exists = User::where($field, $request->query('q'))->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Handle user signup.
     */
    public function signup(Request $request)
    {
        if (Auth::check()) {
            return redirect('home');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:15|regex:/^[a-zA-Z0-9_]{1,15}$/|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|string|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'allow' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect('signup')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
        ]);

        Auth::login($user);

        return redirect('home');
    }
}
