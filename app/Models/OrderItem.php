<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $table = 'orders_items';
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'product_name',
        'variant_color',
        'unit_price',
        'quantity',
        'line_total'
    ];
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function variant(){
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
