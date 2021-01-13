<?php

namespace App\Controllers;

class PagesController
{
    public function index()
    {
        return view('welcome');
    }

    public function home()
    {
        return view('home');
    }

    public function login()
    {
        if (session('logged')) {
            redirect('/pg/home');
        }

        return view('auth/login');
    }

    public function register()
    {
        if (session('logged')) {
            redirect('/pg/home');
        }

        return view('auth/register');
    }

    public function logout()
    {
        session_destroy();
        return redirect('/pg');
    }
}
