<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';
    protected $fillable = [
        'first_name',
        'last_name',
        'rut',
        'birth_date',
    ];
}
