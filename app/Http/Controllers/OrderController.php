<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller{
    public function Index(){
        $user=Auth::user();
        $orders=$user->Orders;
        return OrderResource::collection($orders);
    }
}
