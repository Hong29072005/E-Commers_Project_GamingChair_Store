<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';
    protected $fillable = [
        'product_id',
        'color_name',
        'color_hex',
        'sku',
        'price_adjustment',
        'stock_quantity',
        'is_active'
    ]; 
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function images(){
        return $this->hasMany(ProductImage::class, 'variant_id');
    }
}
