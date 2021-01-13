<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Course;

class PagesController
{
    public function index()
    {
        $course = new Course();
        return view('welcome', [
            'courses' => $course->all()
        ]);
    }

    public function users()
    {
        $user = new User();
        return view('users/index', [
            'users' => $user->all()
        ]);
    }
}
