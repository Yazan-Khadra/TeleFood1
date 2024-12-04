<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TokenMiddleWare
{
    use JsonResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    
    {
        try{
            $user=JWTAuth::parsetoken()->authenticate();
        }
        
        catch(JWTException $e){
         if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->JsonResponse('token Expired',401);
        }
        else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
            return $this->JsonResponse('token Invalid',401);
    }
        else{
        return $this->JsonResponse('Authorization Token NotFound',401);
    }
    }
        return $next($request);
    }
}
