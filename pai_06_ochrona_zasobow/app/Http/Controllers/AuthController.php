<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $login = $request->input('login');
        $pass  = $request->input('pass');

        if ($login === 'admin' && $pass === 'admin') {
            Session::put('user', ['login' => 'admin', 'role' => 'admin']);
            return redirect('/')->with('info', 'Zalogowano jako administrator');
        }

        if ($login === 'user' && $pass === 'user') {
            Session::put('user', ['login' => 'user', 'role' => 'user']);
            return redirect('/')->with('info', 'Zalogowano jako użytkownik');
        }

        return back()->with('error', 'Niepoprawny login lub hasło');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login')->with('info', 'Poprawnie wylogowano z systemu');
    }
}