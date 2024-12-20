<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\JsonResponseTrait;

class CategoryController extends Controller
{
    use JsonResponseTrait;
    public function AddCategory(Request $request){

        $ValidateCategoryData=$validator::make($request->all(),[
            'type'=>'required|string'
        ]);
        if($ValidateCategoryData->fails()){
            return $this->JsonResponse($ValidateCategoryData->errors(),400);
        }
        Category::create($ValidateCategoryData);
        if(isset($ValidateCategoryData)){
            return $this->JsonResponse('Added one new category',201);
        }
            return $this->JsonResponse('Adding category failed',400);
    }
    public function showStoreBy(Request $reuqest){
        $category=Category::get()->where('type',$request->type);
        $categoryStore= $category->stores;
        if(!isset($categoryStore)){
            return $this->JsonResponse('there is no store in this category',404);
        }
            return CategoryResource::collection($categoryStore);

    }
}
