<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
        'title', 
		'percentage', 
		'is_publish',
    ];
}
