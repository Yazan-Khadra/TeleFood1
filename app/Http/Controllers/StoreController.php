<?php

namespace App\Http\Controllers;

use App\Http\Resources\Store\ProductResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Category;
use App\Models\Governorate;
use App\Models\Store;
use App\Models\StoreGovernorate;
use App\Traits\AddStore;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'governorate'=>'required|string',
            'location'=>'required|string',
            'category'=>'required|string',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
        $this->AddStore($request);
        $storeCount=new DashBoardController();
        $storeCount->AddStore();
        return $this->JsonResponse('Store add Successfully',200);
    }
    public function AddBranch(Request $request){
        $validation=Validator::make($request->all(),[
            'store_name'=>'required',
            'governorate'=>'required|string',
            'location'=>'required|string',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
       $this->AddingBranch($request,$request->store_name);
        return $this->JsonResponse('Branch Added Successfully',201);
    }
    public function Delete($storeName){
        Store::where('name',$storeName)->delete();
        return $this->JsonResponse('Deleted Successfully',200);
    }
    public function DeleteAll(){
        DB::table('stores')->delete();
        return $this->JsonResponse('Deleted Successfully',200);
    }
    public function DeleteBranch(Request $request){
        StoreGovernorate::where('store_id',$request->store_id)->where('governorate_id',$request->governorate_id)->delete();
        return $this->JsonResponse('Branch Deleted Successfully',200);

    }
    public function Index(){
        $stores=Store::all();
        return StoreResource::collection($stores);
    }
    public function GetStoreProducts($name){
        $store=Store::where('name',$name)->get()->first();
      
        if(!isset($store->Products)||empty($store->Products)){
            return response()->json(['message'=>'Empty']);
        }
        $products=$store->Products;
        return ProductResource::collection($products);
        
    }
    public function GetGovernorateStores($name){
        $governorate=Governorate::where('name',$name)->get()->first();
        $stores=$governorate->Stores;
        return StoreResource::collection($stores);
    }

}
