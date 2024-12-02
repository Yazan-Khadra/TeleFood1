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
            'quantity'=>'required|numeric'
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
            'quantity'=>$request->quantity,
        ]);
        return $this->JsonResponse("Product added Successfully",200);
    }
  public function Update(Request $request){
    $validation=Validator::make($request->all(),[
        'store_name'=>'required|string',
        'name'=>'required|string',
        'description'=>'required|string',
        'image_url'=>'required|string',
        'price'=>'required|numeric',
        'quantity'=>'required|numeric'
    ]);
    if($validation->fails()){
        return $this->JsonResponse($validation->errors(),400);
    }
    Product::where('id',$request->product_id)->update([
        'name'=>$request->name,
        'description'=>$request->description,
        'price'=>$request->price,
        'image_url'=>$request->image_url,
        'quantity'=>$request->quantity,
    ]);
        return $this->JsonResponse("Product updated Successfully",202);

  }
  public function Delete($id){
    Product::where("id",$id)->delete();
    return $this->JsonResponse("Product Deleted Successfully",200);
  }
  public function DeleteAllForStore($id){
   $store= Store::where('id',$id)->get()->first();
   $products=$store->Products;
   foreach($products as $product){
    Product::where('id',$product->id)->delete();
   }
   return $this->JsonResponse('Deleted Successfully',200);
  }
  public function UpdateQuantity(request $request){
   $product=Product::find($request->id);
   $new_quantity = $product->quantity + $request->quantity;
   $product->update([
    "quantity"=>$new_quantity,
   ]);
  }

}
