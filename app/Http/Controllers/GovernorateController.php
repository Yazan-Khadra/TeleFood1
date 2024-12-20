<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GovernorateController extends Controller{
    private $governorate,$goverorate_info;
    public function __construct($governorate){
        $this->governorate = $governorate;
    }
    public function Create(){
       $this->goverorate_info= Governorate::create([
            'name'=>$this->governorate,
        ]);
        $this->Cache();
    }
    public function Cache(){
        Cache::put($this->goverorate_info->name,$this->goverorate_info->id);
    }
    public function GetGovId(){
        return $this->goverorate_info->id;
    }
}
