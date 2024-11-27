<?php

namespace App\Traits\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;

trait SetTTLTrait{
    
public function getTTL(){
    return  JWTAuth::factory()->getTTL();
}
}
