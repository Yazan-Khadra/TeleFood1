<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\Basket;
use App\Models\Product;
use App\Http\Resources\basket\BasketResource;
use App\Http\Resources\basket\BasketIndexResource;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    use JsonResponseTrait;
    public function CalculatePrice($quantity,$Productprice){
        $price=$quantity*$Productprice;
        return $price;
    }
    public function ShowBasketProducts(){
        $user=Auth::user();
        $userProducts=$user->baskets;
       
    //    foreach($userProducts->products as $userProduct){
    //     dd($userProduct);
    //    }
        if(!isset($userProducts)){
            return $this->JsonResponse('No products found in the basket',404);
        }
        return BasketIndexResource::collection($userProducts);
    }

    public function store(Request $request){
        $validateBasketData=Validator::make($request->all(),[
            'product_id'=>'required|string',
            'quantity'=>'required|string',
            'description'=>'required|string',
        ]);
        if($validateBasketData->fails()){
            return $this->JsonResponse($validateBasketData->errors(),400);
        }
        $user=Auth::user()->id;
        
        $productinfo=Product::where('id',$request->product_id)->get()->first();
        $productPrice=$this->CalculatePrice($request->quantity,$productinfo->price);
        Basket::create([
            'user_id'=>$user,
            'product_id'=>$request->product_id,
            'quantity'=>$request->quantity,
            'description'=>$request->description,
            'total_price'=>$productPrice,
        ]);
            return $this->JsonResponse('Added to Cart Succsesfully',201);
    }
    public function Delete($cartId){
        $user=Auth::user();
        Basket::where('id',$cartId)->delete();
        return $this->JsonResponse('order canceled successfully',200);
    }
    public function DeleteAll(){
        $user_id=Auth::user()->id;
        Basket::where('user_id',$user_id)->delete();
    }
    public function Update(Request $request){
        $user=Auth::user();
        $validateBasketData=Validator::make($request->all(),[
            'quantity'=>'required|string',
            'description'=>'required|string',
        ]);
        if($validateBasketData->fails()){
            return $this->JsonResponse($validateBasketData->errors(),400);
        }
        $basketInfo= Basket::where('id',$request->cartId)->get()->first();
        if($request->quantity!=$basketInfo->quantity){
            $price=$basketInfo->products->price;
            $newPrice=$this->CalculatePrice($request->quantity,$price);
            Basket::where('id',$request->cartId)->update([
                'quantity'=>$request->quantity,
                'description'=>$request->description,
                'total_price'=>$newPrice,
                
            ]);
        }
        else{
            Basket::where('id',$request->cartId)->update([
                'quantity'=>$request->quantity,
                'description'=>$request->description,
            ]);
           
            
        }
        return $this->JsonResponse('order Updated successfully',200);

    }
 
}
