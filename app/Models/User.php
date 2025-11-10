<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Optional: specify table name if it's not the default 'users'
    protected $table = 'users';

    // Optional: if you want mass assignment
    protected $fillable = ['name', 'last_name'];
}
