<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_category extends Model
{
    use HasFactory;
	
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'parent_id',
        'is_publish',
        'og_title',
        'og_description',
        'og_keywords',
    ];	
}
