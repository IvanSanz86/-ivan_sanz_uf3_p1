<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'name', 'year', 'genre', 'country', 'duration', 'img_url'
    ];
}
