<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function store()
    {
        $request = request();

        if (! hash_equals(session('csrf_token'), $request->_csrf)) {
            session(['error' => 'csrf token didnt match.']);
            return redirect()->back();
        }

        $request->validate([
            'email' => ['required', 'email', 'min:10'],
        ]);

        $request->name = "{$request->first_name} {$request->last_name}";

        $user = new User();
        $user->save($request->all());

        return redirect('php-obscure.users');
    }
}
