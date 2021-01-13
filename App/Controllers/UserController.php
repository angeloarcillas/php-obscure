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

        // for ($i=0; $i < 50; $i++) {
        //     $request->name = uniqid();
        //     $request->email = uniqid() . '@mail.com';
        //     $request->address = uniqid() . 'Foobar City';
        //     $request->status = 'pending';
        //     $request->role = 'applicant';

            $user->save($request->all());
        // }
    }
}
