<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pro_category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'sortdescription',
        'description',
        'subheader_image',
        'parent_id',
        'is_subheader',
        'is_publish',
        'og_title',
        'og_description',
        'og_keywords',
    ];
}
