<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu_parent extends Model
{
    protected $fillable = [
        'menu_id', 
		'menu_type', 
		'child_menu_type',
		'item_id',
		'item_label',
		'custom_url',
		'target_window',
		'column',
		'width_type',
		'width',
		'sort_order',
    ];
}
