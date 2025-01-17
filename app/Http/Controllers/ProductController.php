<?php

namespace App\Http\Controllers;

use App\Http\Resources\Store\ProductResource;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller{
    use JsonResponseTrait;
    public function Notify(Product $product){
        $title = 'New Product Added';
        $body = 'Resturant '.$product->Store->name.' '.' has added a new product'.$product->name;

        $users = User::all();
        $notify=new FirebaseNotification();
        foreach ($users as $user) {
            $notify->sendNotification($user->fcm_token, $title, $body, ['product_id' => $product->id]);
        }
       
    }
    public function Create(Request $request){
        $validation=Validator::make($request->all(),[
            'store_name'=>'required|string',
            'name'=>'required|string',
            'description'=>'required|string',
            'image_url'=>'required|string',
            'price'=>'required|numeric',
            'quantity'=>'required',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
        $store_id=Store::where('name',$request->store_name)->get()->first();
       $product= Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'image_url'=>$request->image_url,
            'store_id'=>$store_id->id,
            'quantity'=>$request->quantity,
        ]);
       //  $this->Notify($product);
        // $this->f->notifyUsers($product);
        return $this->JsonResponse("Product added Successfully",200);
    }
 
public function Delete(request $request){
    $store=Store::where('name',$request->store_name)->get()->first();
    Product::where('store_id',$store->id)->where('name',$request->product_name)->delete();
    return $this->JsonResponse('Deleted Successfully',200);
}
public function DeleteAllForStore($store_name){
    $store=Store::where('name',$store_name)->get()->first();
    foreach($store->products as $product){
        $product->delete();
    }
    return $this->JsonResponse('Deleted Successfully',200);
}

}
