<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'product_id',
        'customer_id',
        'order_id',
        'rating',
        'title',
        'comment',
        'is_verified_purchase',
        'created_at'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
