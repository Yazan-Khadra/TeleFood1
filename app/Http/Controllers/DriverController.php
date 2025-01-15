<?php

namespace App\Http\Controllers;

use App\Http\Resources\DriverResource;
use App\Http\Resources\OrderResource;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private $status=false;
    public function GetOrders($driver_id){
        $driver=Driver::where('id',$driver_id)->get()->first();
        $orders=$driver->Orders;
        return DriverResource::collection($orders);
    }
    public function Done($order_id){
       $this->status=true;
       $order=new OrderController();
       $order->NotifyAdmins($order_id);
    }
    public function CheckOrderStatus(){
        return $this->status;
    }
}
