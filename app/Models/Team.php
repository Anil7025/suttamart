<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'designation',
        'is_publish',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
    ];
}
