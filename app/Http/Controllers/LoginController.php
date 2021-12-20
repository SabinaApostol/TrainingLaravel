<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function index()
    {
        session()->pull('admin');
        session()->save();
        return view('login');
    }

    public function store(Request $request) {

        request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($request->input('username') === config('auth.admin_username') && $request->input('password') === config('auth.admin_password')) {
            session()->put('admin', true);
            session()->save();
            return (response('logged_in'));
        }
        return view('login')->withErrors(['invalid_credentials' => 'Invalid credentials!']);
    }
}
