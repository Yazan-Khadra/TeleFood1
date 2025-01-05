<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $fillable=[
        'location',
        'cart_id',
        'user_id'
    ];
    public function Basket(){
        return $this->belongsTo(Basket::class,'cart_id');
    }
}
