<?php

namespace App\Controllers;

use App\Models\Course;

class PagesController
{
    public function __invoke()
    {
        echo "Working...";
    }

    public function index()
    {
        $course = new Course();
        return view('welcome', [
            'courses' => $course->all()
        ]);
    }
}
