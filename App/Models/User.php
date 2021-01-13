<?php

namespace App\Models;

use Core\Blueprint\Models;

class User extends Models
{
    protected $table = 'users';
    protected $fillable = ['name', 'course_id', 'email', 'address', 'status', 'role'];
}