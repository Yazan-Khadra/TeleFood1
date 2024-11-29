<?php

namespace App\Traits;

trait JsonResponseTrait
{
    public function JsonResponse($message,$status){
        $response=['message'=>$message,'status'=>$status];
        return response()->json($response,$status);
    }
}

