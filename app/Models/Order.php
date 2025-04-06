<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_no',
        'transaction_no',
        'customer_id',
        'seller_id',
        'payment_method_id',
        'payment_status_id',
        'order_status_id',
        'total_qty',
        'total_price',
        'discount',
        'tax',
        'subtotal',
        'total_amount',
        'shipping_title',
        'shipping_fee',
        'name',
        'email',
        'phone',
        'country',
        'state',
        'pincode',
        'city',
        'address',
        'comments',
      ];	
}
