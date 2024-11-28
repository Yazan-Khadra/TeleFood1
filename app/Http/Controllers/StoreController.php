<?php

namespace App\Http\Controllers;

use App\Http\Resources\Store\ProductResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Store;
use App\Models\StoreGovernorate;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller{
    use JsonResponseTrait;
    public function Create(Request $request){
        //please uncomment all coments when you finish the categories
       // $category_id=Category::where('type',$request->category)->get()->first();
        $validation=Validator::make($request->all(),[
            'name'=>'required|string|unique:stores',
            'description'=>'required|string',
            'image_url'=>'required|string',
            'rate'=>'required',
            'governorate'=>'required|string|unique:governorates,name',
            'location'=>'required|string',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
       $store= Store::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image_url'=>$request->image_url,
            'rate'=>$request->rate,
            // 'category_id'=>$category_id,
        ]);
         $Governorate=new GovernorateController($request->governorate);
         $Governorate->Create();
         $gov_id=$Governorate->GetGovId();
        $Createlocation=new StoreGovernorateController($store->id,$gov_id,$request->location);
        return $this->JsonResponse('Store add Successfully',200);
    }
    public function Index(){
        $stores=Store::all();
        return StoreResource::collection($stores);
    }
    public function GetStoreProducts($id){
        $store=Store::where('id',$id)->get()->first();
      
        if(!isset($store->Products)||empty($store->Products)){
            return response()->json(['message'=>'Empty']);
        }
        $products=$store->Products;
       
       
        return ProductResource::collection($products);
        
    }
}