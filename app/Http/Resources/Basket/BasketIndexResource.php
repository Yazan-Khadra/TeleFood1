<?php

namespace App\Http\Resources\Basket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userProducts=$this->products;
        return ['product_id'=>$userProducts->id,
                'name'=>$userProducts->name,
                'image_url'=>$userProducts->image_url,
                'price'=>$userProducts->price,
            ];
    }
}
