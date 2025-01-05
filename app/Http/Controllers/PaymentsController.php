<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller{
    use JsonResponseTrait;
    public function Checkout(Request $request){
        $validation=Validator::make($request->all(),[
            'payId'=>'required|numeric',
            'location'=>'required',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
        $deafultPayId="5515355";
        $user=Auth::user();
        if($deafultPayId==$request->payId){
            $user_id=$user->id;
            $cart_id=$request->cartId;
            Order::create([
                'user_id'=>$user_id,
                'cart_id'=>$cart_id,
                'location'=>$request->location,
            ]);
            return $this->JsonResponse('Your Purchase was completed successfully',200);
        }
        else{
            return $this->JsonResponse('invalid Payment Id',400);
        }
    }
}
