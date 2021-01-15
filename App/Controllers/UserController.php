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

        $user = new User();
        $user->create($request->all());

        return redirect('php-obscure.users');
    }

    public function update($id)
    {
        dd('update');
        // $attributes = [
        //     'name' => 'foo',
        //     'email' => 'bar@mail.com',
        //     'role' => 'zxc',
        //     'status' => 'opsec'
        // ];
        // $id = 1;

        $user = new User();
        // $user->update($id, $attributes);
        $user->delete(1);
    }

    public function delete($id)
    {
        dd('delete');
    }
}
