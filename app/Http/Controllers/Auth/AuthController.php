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
        try{
       $validation= Validator::make($request->all(),[
        'first_name'=>'required|string',
        'last_name'=>'required|string',
        'location'=>'required|string',
        'location_details'=>'required|string',
        'mobile'=>'required|min:10|max:10|unique:users',
        'password'=>'required|min:6|max:255',
        'confirm_password'=>'required|same:password'

       ]);

       $image_url="https://w7.pngwing.com/pngs/577/307/png-transparent-human-with-circle-logo-national-cyber-security-alliance-organization-drupal-association-information-internet-icon-s-customers-free-miscellaneous-company-logo.png";
       if($validation->fails()){
        return $this->JsonResponse($validation->errors(),400);
       }
       if(isset($request->image)){
        $image_url=$request->file("image")->getClientOriginalName();
        $path=$request->file('image')->storeAs('UsersImage', $image_url,'TeleFood');
       
       }


       User::create([
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'location'=>$request->location,
        'location_details'=>$request->location_details,
        'image_url'=>$path,
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
            return $this->JsonResponse("the password field is required",400);
        }
        $validation= Validator::make($request->all(),[
            'mobile'=>'required|min:10|max:10|regex:/[0-9]{10}/',
            'password'=>'required',
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
