<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function store()
    {

        $request = request();
        $request->validate([
            'email_address' => ['required', 'email', 'min:3']
        ]);

        $user = new User();

        // change form input names and remove this
        $request->name = "{$request->first_name} {$request->last_name}";
        $request->email = $request->email_address;
        $request->address = $request->street_address;
        $request->status = 'pending';
        $request->role = 'applicant';

        //     $param = [];
        // for ($i=0; $i < 50; $i++) {
        //     $param[] = uniqid();
        //     $param[] = uniqid() . '@mail.com';
        //     $param[] = uniqid() . 'Foobar City';
            $user->save($request->all());
        //     $param = [];
        // }
    }
}
