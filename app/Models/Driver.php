<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable=[
        'driver_name',
        'motoarcycle_number',
    ];
    public function Orders(){
        return $this->hasMany(Order::class,'driver_id');
    }
}
