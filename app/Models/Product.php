<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category_id',
        'brand_id',
        'description',
        'material',
        'max_load_kg',
        'recline_angle',
        'has_footrest',
        'has_lumbar_pillow',
        'has_headrest_pillow',
        'armrest_type',
        'base_price',
        'sale_price',
    ];
}
