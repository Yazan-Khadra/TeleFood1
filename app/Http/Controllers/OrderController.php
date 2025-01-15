<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Notifications\StatusNotification;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller{
    use JsonResponseTrait;
    private $status=false;
   
    public function Index(){
        $user=Auth::user();
        $orders=$user->Orders;
        return OrderResource::collection($orders);
    }
    public function Done($order_id){
        $this->status=true;
        $user=Auth::user();
        
        $this->NotifyUsers($order_id,$user->id);
    }
    public function CheckOrderStatus(){
        
        return $this->status;
    }
   
    public function NotifyAdmins($order_id){

           $Admins=User::where('role','admin')->get()->all();
           $title="Order Arrived Successfully !";
           $message="Order with Id ".$order_id." "."Arrived Successfully";
           Notification::send($Admins,new StatusNotification($title,$message));
    
}
public function NotifyUsers($order_id,$user_id){
    $user=User::where('id',$user_id)->get()->first();
    $title="Order Arrived Successfully !";
    $message="Order with Id ".$order_id." "."Arrived Successfully";
    Notification::send($user,new StatusNotification($title,$message));

}
}
