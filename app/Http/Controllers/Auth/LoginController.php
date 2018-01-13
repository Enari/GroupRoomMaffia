<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            // Authentication passed...
            return redirect()->intended('/');
        } else {
            return redirect('/login')->withErrors(['login' => 'Invalid Credentials']);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
