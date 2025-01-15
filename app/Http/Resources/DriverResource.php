<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $location=$this->location;
        $productInfo=$this->Products;
        $Products=$productInfo->products;
        return [
            'cart_id'=>$this->id,
                'product_id'=>$Products->id,
                'name'=>$Products->name,
                'description'=>$productInfo->description,
                'quantity'=>$productInfo->quantity,
                'image_url'=>$Products->image_url,
                'total price'=>$productInfo->total_price,

        ];
    }
}
