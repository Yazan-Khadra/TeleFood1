<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller{
    use JsonResponseTrait;
    public function getUserInfo()
    {
        
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->JsonResponse('user not found',400);
            }
        } catch (JWTException $e) {
            return $this->JsonResponse('invalid token',400);
        }

        return response()->json(compact('user'));
}
}
