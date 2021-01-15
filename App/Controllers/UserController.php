<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
     public function index()
    {
        $user = new User();
        return view('users/index', [
            'users' => $user->all()
        ]);
    }

    public function store()
    {
        $request = request();

        if (! hash_equals(session('csrf_token'), $request->_csrf)) {
            session(['error' => 'csrf token didnt match.']);
            return redirect()->back();
        }

        $request->validate([
            'email' => ['required', 'email', 'min:10'],
            'address' => ['required', 'min:10'],
        ]);

        $request->name = "{$request->first_name} {$request->last_name}";
            // dd($request->all());
        $user = new User();
        $user->create($request->all());

        return redirect('php-obscure.users');
    }

    public function edit($id)
    {
        return view('users.edit', [
            'user' => (new User())->find($id),
            'courses' => (new \App\Models\Course())->all()
        ]);
    }

    public function update($id)
    {
        $request = request();

        verifyCsrf($request->_csrf);

        $user = new User();
        $user->update($id, $request->all());

        return redirect("/php-obscure/users");
    }

    public function delete($id)
    {
        $request = request();

        verifyCsrf($request->_csrf);

        (new User())->delete($id);
        return redirect('php-obscure/users');
    }
}
