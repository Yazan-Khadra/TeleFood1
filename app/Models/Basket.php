<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable =[
        'user_id',
        'product_id',
        'size',
        'description',
        'quantity',
        'total_price',
    ];
    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function Orders(){
        return $this->hasMany(Order::class,'cart_id');
    }
}
