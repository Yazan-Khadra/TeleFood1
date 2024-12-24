<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\Basket;
use App\Http\Resources\basket\BasketResource;
use App\Http\Resources\basket\BasketIndexResource;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    use JsonResponseTrait;

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
            'size'=>'required|string',
            'quantity'=>'required|string',
            'description'=>'required|string',
            'total_price'=>'required|numeric',
            'location'=>'required|string'
        ]);
        if($validateBasketData->fails()){
            return $this->JsonResponse($validateBasketData->errors(),400);
        }
        $user=Auth::user()->id;
        Basket::create([
            'user_id'=>$user,
            'product_id'=>$request->product_id,
            'size'=>$request->size,
            'quantity'=>$request->quantity,
            'description'=>$request->description,
            'total_price'=>$request->total_price,
            'location'=>$request->location
        ]);
            return $this->JsonResponse('Added to Cart Succsesfully',201);
    }
    public function edit(Request $request){
        $validateEditData=validator::make($request->all(),[
            'product_id'=>'required',
            'quantity'=>'required|string',
            'description'=>'required|string',
            'location'=>'required|string' ]);
            if($validateEditData->fails()){
                return $this->JsonResponse($validateEditData->errors(),400);
            }
            $user=Auth::user()->id;
            $userBasket=$user->baskets();
            $userProduct=$userBasket->products->where('id',$request->product_id);
            if(!$userProduct){
                 return $this->JsonResponse('Updating failed',400);
            }
            $userProduct->update([
                'quantity'=>$request->quantity,
                'description'=>$request->description,
                'location'=>$request->location
            ]);
                 return $this->JsonResponse('Updated Succsesfully',202);

    }
    public function delete(Request $request){

            $user=Auth::user();
            $userBasket=$user->baskets;
            $userProduct=$userBasket->products->where('id',$request->product_id);
            if(!$userProduct){
                return $this->JsonResponse('Product Not Found',400);
            }
            $userProduct->delete();
            if(isset($userProduct)){
                return $this->JsonResponse('Deleted sucessfully',200);
            }
            return $this->JsonResponse('Deleting failed',400);
    }
    public function deleteAll(){
        $user=Auth::user();
        $basketAllProducts=$user->baskets;
        if(!isset($basketAllProducts)){
            return $this->JsonResponse('there is no product in the basket to delete',404);
        }
        $deleteBasket=$basketAllProducts->delete();
        if(isset($deleteBasket)){
            return $this->JsonResponse('All product deleted from the basket',200);
        }

    }
}
