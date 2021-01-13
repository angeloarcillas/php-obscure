<?php

namespace App\Models;

use Core\Blueprint\Models;

class User extends Models
{
    protected $table = 'users';
    protected $fillable = ['email','password'];
    protected $key = 'email';
}