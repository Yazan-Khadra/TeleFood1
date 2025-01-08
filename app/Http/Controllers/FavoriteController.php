<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Traits\JsonResponseTrait;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Http\Resources\Store\ProductResource;
use App\Models\Favorite;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    use JsonResponseTrait;
  public function AddToFavorite(Request $request){

    $user=Auth::user();
    Favorite::create([
        'user_id'=>$user->id,
        'product_id'=>$request->product_id,
    ]);
    return $this->JsonResponse('Added to Favorite successfully',200);
  }
  public function Delete($product_id){
    $user=Auth::user();
    Favorite::where('user_id',$user->id)->where('product_id',$product_id)->delete();
    return $this->JsonResponse('Deleted Successfully',200);
  }
  public function Index(){
    $user=Auth::user();
    $favorites=$user->Favorites;
    return ProductResource::collection($favorites);
  }


}
