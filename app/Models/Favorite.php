<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable=[
        'user_id',
        'product_id'
    ];
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this->belongTo(Product::class);
    }

}
