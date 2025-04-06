<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'sort_description',
        'description',
        'is_publish',
    ];
}
