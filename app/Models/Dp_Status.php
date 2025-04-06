<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dp_Status extends Model
{
    protected $table = 'dp__statuses';
	
    protected $fillable = [
        'status',
    ];
}
