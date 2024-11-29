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
        'total_price'
    ];
    public function products(){
        return $this->belongToMany(Product::class);
    }
    public function users(){
        return $this->belongToMany(User::class);
    }
}
