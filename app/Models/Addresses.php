<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    public $timestamps = false;
    protected $table = 'addresses';
    protected $fillable = [
        'customer_id ',
        'label',
        'full_name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default'
    ];
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
}
