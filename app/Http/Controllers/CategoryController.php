<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\Store\StoreResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\JsonResponseTrait;

class CategoryController extends Controller
{
    use JsonResponseTrait;
    public function AddCategory(Request $request){

        $ValidateCategoryData=Validator::make($request->all(),[
            'type'=>'required|string|unique:categories',
        ]);
        if($ValidateCategoryData->fails()){
            return $this->JsonResponse($ValidateCategoryData->errors(),400);
        }
        Category::create([
            'type'=>$request->type,
        ]);
            return $this->JsonResponse('Added one new category',201);
    }
    public function showStoreBy($type){
        $category=Category::where('type',$type)->get()->first();
        $categoryStore= $category->stores;
        if(!isset($categoryStore)){
            return $this->JsonResponse('there is no store in this category',404);
        }
            return StoreResource::collection($categoryStore);

    }
}
