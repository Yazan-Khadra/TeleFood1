<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Traits\JsonResponseTrait;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller{
 use JsonResponseTrait;
    public function Register(Request $request){
        if($request->first_name=="null"){
            return $this->JsonResponse("First name field can't be null",400);
        }
        if($request->last_name=="null"){
            return $this->JsonResponse("Last name field can't be null",400);
        }
        if($request->location=="null"){
            return $this->JsonResponse("location field can't be null",400);
        }
        if($request->location_details=="null"){
            return $this->JsonResponse("location details field can't be null",400);
        }
        if($request->image=="null"){
            return $this->JsonResponse("Image field can't be null",400);
        }
        if($request->mobile=="null"){
            return $this->JsonResponse("mobile phone Field can't be null",400);
        }
        if($request->password=="null"){
            return $this->JsonResponse("password Field can't be null",400);
        }
        if($request->confirm_password=="null"){
            return $this->JsonResponse("confirm password Field can't be null",400);
        }
        try{
       $validation= Validator::make($request->all(),[
        'first_name'=>'string',
        'last_name'=>'string',
        'location'=>'string',
        'location_details'=>'string',
        'image'=>'string',
        'mobile'=>'min:10|max:10|unique:users',
        'password'=>'min:6|max:255',
        'confirm_password'=>'same:password'
       ]);
       

       $image_url="https://w7.pngwing.com/pngs/577/307/png-transparent-human-with-circle-logo-national-cyber-security-alliance-organization-drupal-association-information-internet-icon-s-customers-free-miscellaneous-company-logo.png";
       if($validation->fails()){
        return $this->JsonResponse($validation->errors(),400);
       }
       if(isset($request->image)){
        $image_url=$request->image;
       }


       User::create([
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'location'=>$request->location,
        'location_details'=>$request->location_details,
        'image_url'=>$image_url,
        'mobile'=>$request->mobile,
        'password'=>Hash::make($request->password),
        'fcm_token'=> $request->fcmToken,
       ]);
    }
    catch(Exception $e){
        return $this->JsonResponse($e,400);
    }
       return $this->JsonResponse('Registration done successfully',201);
    }
    public function Login(Request $request){
        if($request->mobile=="null"){
            return $this->JsonResponse("the mobile field is required ",400);
        }
        else if($request->password=="null"){
            return $this->JsonResponse("the password field is required ",400);
        }
        $validation= Validator::make($request->all(),[
            'mobile'=>'min:10|max:10|regex:/[0-9]{10}/',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
    }
    $credintials=$request->only('mobile','password');
    try{
    if(!$token=JWTAuth::attempt($credintials)){
        return $this->JsonResponse('invalid mobile number or password',401);
    }
    $user=Auth::user();
    $token = JWTAuth::claims(['first_name'=>$user->first_name,'last_name'=>$user->last_name,'location'=>$user->location,'role' => $user->role])->fromUser($user);

}
catch (JWTException $e) {

    return $this->JsonResponse('invalid token',400);
        }
        $response=['message'=>'Welcome '.Auth::user()->first_name,'token'=>$token,'status'=>200];
    return response()->json($response,200);
    }

public function Logout(){
    JWTAuth::invalidate(JWTAuth::getToken());
        return $this->JsonResponse('logout successfully',200);
    }
    public function Refresh(){
      /** @var Illuminate\Auth\AuthManger*/;


    }
    public function CreateNewToken($token){
        return response()->json([
            'Token'=>$token,
            'Expires_in'=>Auth::factory()->getTTL()*60*60 ."hours",
            'User'=>Auth::user()->first_name,
        ]);
    }
}
