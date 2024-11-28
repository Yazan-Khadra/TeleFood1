<?php

namespace App\Http\Controllers;

use App\Http\Resources\Store\ProductResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Category;
use App\Models\Store;
use App\Models\StoreGovernorate;
use App\Traits\AddStore;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller{
    use JsonResponseTrait,AddStore;
    public function Create(Request $request){
        //please uncomment all coments when you finish the categories
        $validation=Validator::make($request->all(),[
            'name'=>'required|string|unique:stores',
            'description'=>'required|string',
            'image_url'=>'required|string',
            'rate'=>'required',
            'governorate'=>'required|string|unique:governorates,name',
            'location'=>'required|string',
            'category'=>'required|string',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
        $this->AddStore($request);
     
        return $this->JsonResponse('Store add Successfully',200);
    }
    public function AddBranch(Request $request){
        $validation=Validator::make($request->all(),[
            'store_id'=>'required',
            'governorate'=>'required|string|unique:governorates,name',
            'location'=>'required|string',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
        $this->AddStore($request,$request->store_id);
        return $this->JsonResponse('Branch Added Successfully',201);
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
