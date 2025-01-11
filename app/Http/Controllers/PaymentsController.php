<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Faker\Generator as Faker;

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

            $confirm_cart=Basket::where('user_id',$user_id)->get();
            $addOrder=new DashBoardController();
            $faker=new Faker();
            $randomNumber=$faker->numberBetween(1,3);
            
            foreach($confirm_cart as $item){
           Order::create([
            'location'=>$request->location,
            'user_id'=>$user_id,
            'order_id'=>$item->id,
            'driver_id'=>$randomNumber,
           ]);
            $addOrder->AddOrder();
            // $total_price=$order->Basket->total_price;
            $addOrder->AddToReturns(12000);
        }
        if(isset($request->tips)){
            $addOrder->AddToTips($request->tips);
        }
        $deleteFromCart=new BasketController();
        $deleteFromCart->DeleteAll();
            return $this->JsonResponse('Your Purchase completed successfully',200);
        }
        else{
            return $this->JsonResponse('invalid Payment Id',400);
        }
    }
}
