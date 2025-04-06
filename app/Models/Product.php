<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'image2',
        'short_desc',
        'description',
        'extra_desc',
        'cost_price',
        'sale_price',
        'old_price',
        'start_date',
        'end_date',
        'is_discount',
        'is_stock',
        'sku',
        'stock_status_id',
        'stock_qty',
        'u_stock_qty',
        'category_ids',
        'cat_id',
        'brand_id',
        'collection_id',
        'shop_id',
        'variation_color',
        'variation_size',
        'tax_id',
        'is_featured',
        'is_publish',
        'user_fullName',
        'og_title',
        'og_description',
        'og_keywords',
    ];
}
