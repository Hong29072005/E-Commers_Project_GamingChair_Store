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
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function variant(){
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
    public function images(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function review()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
    
}
