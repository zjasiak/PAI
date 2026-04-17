<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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

        // Sprawdzenie w bazie + pobranie roli
        $user = DB::table('uzytkownicy')
            ->join('role', 'uzytkownicy.rola_id', '=', 'role.id')
            ->where('uzytkownicy.login', $login)
            ->where('uzytkownicy.haslo', $pass)
            ->select('uzytkownicy.login', 'role.rola as role')
            ->first();

        if ($user) {
            Session::put('user', [
                'login' => $user->login,
                'role'  => $user->role
            ]);

            return redirect('/')
                ->with('info', 'Zalogowano jako ' . ($user->role === 'admin' ? 'administrator' : 'użytkownik'));
        }

        return back()->with('error', 'Niepoprawny login lub hasło');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login')->with('info', 'Poprawnie wylogowano z systemu');
    }
}