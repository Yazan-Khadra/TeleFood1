<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchBarController;
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
        Route::post('store/create','Create');
        Route::post('store/addbranch','AddBranch');
        Route::post('store/deletebranch','DeleteBranch');
        Route::delete('store/delete/{id}','DeleteStore');
        Route::delete('store/delete/all','DeleteAll');
        Route::get('stores/get','Index');
        Route::get('store/products/{id}','GetStoreProducts');
        Route::get('governorate/stores/{id}','GetGovernorateStores');
});
Route::controller(ProductController::class)->group(function(){
Route::post('product/add','Create');
Route::delete('product/delete/{id}', 'Delete');
Route::delete('products/delete/{id}','DeleteAllForStore');
});
Route::controller(SearchBarController::class)->group(function(){
    Route::post('search','Search');
});
});
