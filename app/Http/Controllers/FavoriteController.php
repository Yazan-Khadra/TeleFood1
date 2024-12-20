<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Traits\JsonResponseTrait;
use App\Http\Resources\Favorite\FavoriteResource;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    use JsonResponseTrait;
    public function store(Request $request){
        Auth::user()->id;
        $ValidateFavData=validator::make($request->all(),[
            'product_id'=>'required|string',
            'user_id'=>'required|string',
        ]);
        if($ValidateFavData->fails()){
            return $this->JsonResponse($ValidateFavData->errors(),400);
        }
        $FavpuriteData=Favorite::create($ValidateFavData);
        if(isset($FavpuriteData)){
            return $this->JsonResponse('Data added to favorite page succsesfully',201);
        }
        return $this->JsonResponse('Adding to favorite failed',400);
    }
    public function ShowFavoritePage(){
        $user=Auth::user();
        $userFavoriteProduct=$user->products;
        if(!isset($userFavoriteProduct)){
            return $this->JsonResponse('There is no favorite product');
        }
        return FavoriteResource::collection($userFavoriteProduct);
    }
    public function deleteProduct(Request $request){

        $user=Auth::user();
        $userFavoriteProduct=$user->product->where('id',$request->product_id);
        if(!isset($userFavoriteProduct)){
            return $this->JsonResponse('there is no data to delete',404);
        }
        $userFavoriteProduct->delete();
            return $this->JsonResponse('Product deleted from favorite page');

    }
    public function deleteAll(){
        $user=Auth::user();
        $FavoriteAllProducts=$user->products;
        if(!isset($FavoriteAllProducts)){
            return $this->JsonResponse('there is no product in the Favorite to delete',404);
        }
        $deleteFavorite=$FavoriteAllProducts->delete();
        if(isset($deleteFavorite)){
            return $this->JsonResponse('All product deleted from the favorite',200);
        }

    }


}
