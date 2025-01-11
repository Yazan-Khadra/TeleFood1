<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $fillable=[
        'location',
        'order_id',
        'driver_id',
        'user_id',
        'arrivial_time',
    ];
   public function Driver(){
    return $this->belongsTo(Driver::class,'driver_id');
   }
}
