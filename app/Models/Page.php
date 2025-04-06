<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 
		'slug', 
		'content', 
        'description',
		'image', 
		'is_publish', 
		'og_title', 
		'og_description', 
		'og_keywords',
    ];
}
