<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;
    protected $table = 'coupons';
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'valid_from',
        'valid_until',
        'usage_limit',
        'used_count',
        'is_active'
    ];
    public function order(){
        return $this->hasMany(Order::class, 'coupon_id');
    }
}
