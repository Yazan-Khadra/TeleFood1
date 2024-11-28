<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model{
    protected $fillable=[
        'name',
    ];
    public function Store(){
        return $this->belongsToMany(Store::class,'store_governorates');
    }
}