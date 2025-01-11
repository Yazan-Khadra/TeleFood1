<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class DashBoardController extends Controller{
    use JsonResponseTrait;
    public function AddUser(){
        $numberOfUsers=Cache::get('number_of_users');
        $numberOfUsers++;
        Cache::put('number_of_users',$numberOfUsers);
    }
    public function GetNumberOfUsers(){
        $numberOfUsers=Cache::get('number_of_users');
        return $this->JsonResponse($numberOfUsers,200);
    }
    public function AddStore(){
        $storesNumber=Cache::get('number_of_stores');
        $storesNumber++;
        cache::put('number_of_stores',$storesNumber);
    }
    public function GetStoresNumber(){
        $storesNumber=Cache::get('number_of_stores');
        return $this->JsonResponse($storesNumber,200);
    }
    public function GetAdmins(){
        $Admins=User::where('role','admin')->get()->all();
        return UserResource::collection($Admins);
    }
    public function AddOrder(){
        $ordersNumber=Cache::get('number_of_orders');
        $ordersNumber++;
        Cache::put('number_of_orders',$ordersNumber);
    }
    public function GetOrdersNumber(){
        $ordersNumber=cache::get('number_of_orders');
        return $this->JsonResponse($ordersNumber,200);
    }
    public function AddToReturns($ammount){
        $cacheReturns=Cache::get('returns');
        $returns=$cacheReturns+$ammount;
        Cache::put('returns',$returns);
    }
    public function GetReturns(){
        $returns=Cache::get('returns');
        return $this->JsonResponse($returns,200);
    }
    public function AddToTips($ammount){
        $cacheTips=Cache::get('tips');
        $Tips=$cacheTips+$ammount;
        Cache::put('tips',$Tips);
    }
    public function GetTips(){
        $tips=Cache::get('tips');
        return $this->JsonResponse($tips,200);
    }
}
