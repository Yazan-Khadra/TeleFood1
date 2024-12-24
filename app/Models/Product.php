<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $fillable=[
        'name',
        'description',
        'image_url',
        'price',
        'store_id',
        'quantity',
    ];
    public function Store(){
        return $this->belongsto(Store::class);
    }
    public function Baskets(){
        return $this->hasMany(Basket::class);
    }
    public function products(){
        return $this->belongToMany(User::class,'favorites');
    }
}
