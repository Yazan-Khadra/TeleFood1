<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller{
    use JsonResponseTrait;
    public function Create(Request $request){
        //please uncomment all coments when you finish the categories
       // $category_id=Category::where('type',$request->category)->get()->first();
        $validation=Validator::make($request->all(),[
            'name'=>'required|string',
            'description'=>'required|string',
            'image_url'=>'required|string',
        ]);
        if($validation->fails()){
            return $this->JsonResponse($validation->errors(),400);
        }
        Store::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image_url'=>$request->image_url,
            // 'category_id'=>$category_id,
        ]);
        return $this->JsonResponse('Store add Successfully',200);
    }
}
