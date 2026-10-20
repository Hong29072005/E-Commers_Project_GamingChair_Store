<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $fillable = [
        'customer_id',
        'product_id',
        'created_at'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
