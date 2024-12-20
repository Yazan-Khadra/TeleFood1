<?php

namespace App\Traits;

use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\StoreGovernorateController;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

trait AddStore{
    public function AddStore(Request $request){
        $category_id=Category::where('type',$request->category)->get()->first();
        
        $store= Store::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image_url'=>$request->image_url,
            'rate'=>$request->rate,
            'category_id'=>$category_id->id,
        ]);
        $StoreIdForAddingBranch=$store->id;
    $gov_id=Cache::get($request->governorate);
    if( $gov_id==null){
         $Governorate=new GovernorateController($request->governorate);
         $Governorate->Create();
         $gov_id=$Governorate->GetGovId();
    }
  
    $Createlocation=new StoreGovernorateController($StoreIdForAddingBranch,$gov_id,$request->location);
  }
  public function AddingBranch(request $request,$storeName){
    $storeId=Store::where('name',$request->store_name)->get()->first();
    $gov_id=Cache::get($request->governorate);
    if( $gov_id==null){
         $Governorate=new GovernorateController($request->governorate);
         $Governorate->Create();
         $gov_id=$Governorate->GetGovId();
    }
  
    $Createlocation=new StoreGovernorateController($storeId->id,$gov_id,$request->location);

  }
}
