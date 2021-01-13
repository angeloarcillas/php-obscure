<?php

namespace App\Controllers;

use App\Models\User;

class PagesController
{
    public function index()
    {
        return view('welcome');
    }

    public function users()
    {
        $user = new User();

        return view('users/index', [
            'users' => $users = $user->all()
        ]);
    }
}
