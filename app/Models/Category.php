<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table= 'categories';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id'
    ];
    //Self Reference (Perent/Children)
    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
    
}
