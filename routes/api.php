<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
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
});
