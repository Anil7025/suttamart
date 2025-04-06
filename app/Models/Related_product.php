<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Related_product extends Model
{
    protected $fillable = [
        'product_id',
        'related_item_id'
    ];
}
