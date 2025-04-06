<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'category_id',
        'is_publish',
        'og_title',
        'og_description',
        'og_keywords',
        'user_name',
    ];	
}
