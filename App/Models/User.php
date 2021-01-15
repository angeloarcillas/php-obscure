<?php

namespace App\Models;

use Core\Blueprint\Models;

class User extends Models
{
    protected $table = 'users';
    protected $fillable = [
        'name', 'email',
        'address', 'status',
        'role', 'course_name',
        'course_major'
    ];


}