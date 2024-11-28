<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use App\Models\StoreGovernorate;
use Illuminate\Http\Request;

class StoreGovernorateController extends Controller{
    private $store_id,$governorate_id,$location;
    public function __construct($store_id,$governorate_id,$location){
        $this->store_id=$store_id;
        $this->governorate_id=$governorate_id;
        $this->location=$location;
        $this->Create();
}
public function Create(){
    StoreGovernorate::create([
        'governorate_id'=>$this->governorate_id,
        'store_id'=>$this->store_id,
        'location'=>$this->location,
    ]);
}

}
