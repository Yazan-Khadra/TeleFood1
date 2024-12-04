<?php

namespace App\Http\Controllers;

use App\Http\Resources\Store\ProductResource;
use App\Models\Product;
use App\Models\Store;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller{
    use JsonResponseTrait;
    public function Create(Request $request){
        $validation=Validator::make($request->all(),[
            'store_name'=>'required|string',
            'name'=>'required|string',
            'description'=>'required|string',
            'image_url'=>'required|string',
            'price'=>'required|numeric',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
        $store_id=Store::where('name',$request->store_name)->get()->first();
        Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'image_url'=>$request->image_url,
            'store_id'=>$store_id->id,
        ]);
        return $this->JsonResponse("Product added Successfully",200);
    }
    public function Index($id){


    }
}
