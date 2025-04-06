<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'item_id', 
        'user_id', 
		'rating',
		'comments',
    ];
}
