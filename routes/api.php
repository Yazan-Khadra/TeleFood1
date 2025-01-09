<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
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
Route::controller(BasketController::class)->group(function(){
    Route::get('basket/index','ShowBasketProducts')->middleware(['Token']);
    Route::post('basket/store','store')->middleware('Token');
    Route::post('basket/update','Update')->middleware('Token');
    Route::delete('basket/delete/{cartId}','Delete')->middleware('Token');
    Route::delete('basket/delete/{name}','delete')->middleware('Token');
    Route::delete('basket/deleteAll','deleteAll')->middleware('Token');

    });
Route::controller(FavoriteController::class)->group(function(){
    Route::post('favorite/add','AddToFavorite')->middleware('Token');
    Route::get('favorite/index','Index')->middleware('Token');
    Route::delete('favorite/delete/{product_id}','Delete')->middleware('Token');
});
Route::controller(CategoryController::class)->group(function(){
    Route::post('category/add','AddCategory');
    Route::get('category/showStore/{type}','showStoreByCategory');
    Route::get('category/get','Index');
});
    Route::controller(StoreController::class)->group(function(){
        Route::post('store/create','Create');
        Route::post('store/addbranch','AddBranch');
        Route::post('store/delete/branch','DeleteBranch');
        Route::delete('store/delete/{name}','Delete');
        Route::get('stores/get','Index');
        Route::get('store/products/{name}','GetStoreProducts');
        Route::get('governorate/stores/{name}','GetGovernorateStores');

});
Route::controller(ProductController::class)->group(function(){
Route::post('product/add','Create');
Route::post('product/delete','Delete');
Route::delete('delete/all/{name}','DeleteAllForStore');
});
});
Route::controller(SearchBarController::class)->group(function(){
Route::get('search/{name}',"Search");
});
Route::controller(PaymentsController::class)->group(function(){
    Route::post('checkout','Checkout')->middleware(['Token']);
});
Route::controller(OrderController::class)->group(function(){
    Route::get('orders','Index')->middleware('Token');
});
Route::controller(DashBoardController::class)->group(function(){
    Route::get('usersNum/get','GetNumberOFUsers');
    Route::get('storesNum/get','GetStoresNumber');
    Route::get('get/admins','GetAdmins');
    Route::get('orders/number/get','GetOrdersNumber');
    Route::get('returns','GetReturns');
});

