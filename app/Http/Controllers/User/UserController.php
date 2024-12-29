<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

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
public function UpdateName(Request $request){
    $validation=Validator::make($request->all(),[
        'first_name'=>'string',
        'last_name'=>'string',
    ]);
    if($validation->fails()){
        return $this->JsonResponse($validation->errors(),400);
    }
    $user=Auth::user();
    User::where('id',$user->id)->update([
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
    ]);
    return $this->JsonResponse(" updated Successfully",201);
}
public function UpdateImage(Request $request){
    $validation=Validator::make($request->all(),[
        'image'=>'required|image',
    ]);
    if($validation->fails()){
        return $this->JsonResponse($validation->errors(),400);
    }
    $user=Auth::user();
    $image_url=$request->file("image")->getClientOriginalName();
    $path=$request->file('image')->storeAs('UsersImage', $image_url,'TeleFood');
    User::where('id',$user->id)->update([
        'image_url'=>$path,
    ]);
    return $this->JsonResponse('Updated Successfully',201);

}
public function UpdateLocation(Request $request){
    $validation=Validator::make($request->all(),[
        'location'=>'required|string',
        'location_details'=>'required|string',
    ]);
    if($validation->fails()){
        return $this->JsonResponse($validation->errors(),400);
    }
    $user=Auth::user();
    User::where('id',$user->id)->update([
        'location'=>$request->location,
        'location_details'=>$request->location_details,
    ]);
    return $this->JsonResponse('Updated Successfully',201);

}
public function UpdatePassword(Request $request){
    if($request->old_password=="null"){
        return $this->JsonResponse('old password field can not be null',400);
    }
    if($request->new_password=="null"){
        return $this->JsonResponse('old password field can not be null',400);
    }
    $oldPassword=Hash::make($request->old_password);
    $user=Auth::user();
    $user_details=User::where('id',$user->id)->get()->first();
    if($oldPassword!=$user_details->password){
        return $this->JsonResponse("old password doesnt match with user password",400);
    }
    else{
        User::where('id',$user->id)->update([
            'password'=>Hash::make($request->new_password),
        ]);
        return $this->JsonResponse('password updated Successfully',201);
    }
}
}
