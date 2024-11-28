<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminsMiddleWare
{
    use JsonResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user=JWTAuth::parsetoken()->authenticate();
        
        if(Auth::user()->role!='admin'){
            return $this->JsonResponse('only admin can access',401);
    }
    return $next($request);
}
}
