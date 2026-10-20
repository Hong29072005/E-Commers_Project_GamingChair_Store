<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'customer_id',
        'status',
        'shipping_address_id',
        'billing_address_id',
        'coupon_id',
        'subtotal',
        'discount_amount',
        'shipping_cost',
        'tax_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'tracking_number',
        'notes',
    ];
    protected $casts = [
        'subtotal'        => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost'   => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'total_amount'    => 'decimal:2',
    ];
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function shippingAddress()
    {
        return $this->belongsTo(Addresses::class, 'shipping_address_id');
    }
    public function billingAddress()
    {
        return $this->belongsTo(Addresses::class, 'billing_address_id');
    }
    public function coupon(){
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    public function payments(){
        return $this->hasMany(Payment::class, 'order_id');
    }
    public function items(){
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
