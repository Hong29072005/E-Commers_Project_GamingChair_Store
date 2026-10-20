<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password_hash',
        'is_active'
    ];
    // លាក់ password_hash មិនឱ្យ Return ក្នុង JSON Response
    protected $hidden = [
        'password_hash',
    ];
    public function addresses()
    {
        return $this->hasMany(Addresses::class, 'customer_id');
    }
    public function cart()
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }
    public function order()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
    public function review()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }
}
