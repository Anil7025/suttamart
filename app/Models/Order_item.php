<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    protected $table = 'order_items';
	
    protected $fillable = [
		'order_id',
		'customer_id',
		'seller_id',
		'product_id',
		'variation_size',
		'variation_color',
		'quantity',
		'price',
		'total_price',
		'tax',
		'discount',
    ];	
}
