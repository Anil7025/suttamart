<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu_child extends Model
{
    protected $table = 'menu_children';
	
    protected $fillable = [
        'menu_id', 
        'menu_parent_id', 
        'mega_menu_id', 
        'menu_type', 
        'item_id', 
        'item_label', 
        'custom_url', 
        'target_window',
        'sort_order', 

    ];	
}
