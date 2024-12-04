<?php

namespace App\Traits;

trait JsonResponseTrait
{
    public function JsonResponse($message,$status){
        $response=['message'=>$message,'status'=>$status];
        return response()->json($response,$status);
    }
    public function JsonResponseShow($data,$message,$status){
        $response=['data'=>$data,
                   'message'=>$message,
                   'status'=>status ];
        return response($response);
    }

}

