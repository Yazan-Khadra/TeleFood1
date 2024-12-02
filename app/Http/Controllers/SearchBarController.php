<?php

namespace App\Http\Controllers;

use App\Http\Resources\Store\ProductResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Product;
use App\Models\Store;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class SearchBarController extends Controller{
    use JsonResponseTrait;
    public function Search(request $request){
       $info=Store::where('name',$request->name)->get()->first();
       if(isset($info)){
       return StoreResource::make($info);
       }
       $info=Product::where('name',$request->name)->first();
       if(isset($info)){
        return ProductResource::make($info);
        }
        return $this->JsonResponse('not exist',400);
      
    }
}