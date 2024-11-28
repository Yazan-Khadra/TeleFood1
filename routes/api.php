<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//Authintication

Route::controller(AuthController::class)->group(function(){
Route::post('register','Register');
Route::post('login','Login');
Route::middleware('Token')->group(function(){
    Route::post('logout','Logout');
    Route::post('refreshToken','Refresh');
});
Route::controller(UserController::class)->group(function(){
    Route::middleware('Token')->group(function(){
    Route::get('UserInfo','getUserInfo');
    });
});
    Route::controller(StoreController::class)->group(function(){
        Route::post('store/create','Create')->middleware(['Token','Admin']);
        Route::get('stores/get','Index');
        Route::get('store/products/{id}','GetStoreProducts');
       
});
Route::controller(ProductController::class)->group(function(){
Route::post('product/add','Create')->middleware(['Token','Admin']);
});
});
