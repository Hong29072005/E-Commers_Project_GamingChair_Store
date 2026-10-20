<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;
    protected $table = 'brands';
    protected $fillable = [
        'name',
        'logo_url',
        'description'
    ];
    public function product(){
        return $this->hasMany(Product::class, 'brand_id');
    }
}
