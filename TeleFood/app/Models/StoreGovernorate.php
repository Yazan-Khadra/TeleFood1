<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreGovernorate extends Model{
    protected $fillable=[
        'store_id',
        'governorate_id',
        'location',
    ];
    public function Store(){
        return $this->belongsTo(Store::class,'store_id');
    }
    public function Governorate(){
        return $this->belongsTo(Governorate::class,'governorate_id');
        
    }
}
