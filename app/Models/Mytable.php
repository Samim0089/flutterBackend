<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mytable extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'mytable';

    // Allow mass assignment
    protected $fillable = ['name', 'location', 'bloodGroup','phonenumber'];

    // Disable timestamps if your table doesn't have created_at/updated_at
    public $timestamps = false;
}
