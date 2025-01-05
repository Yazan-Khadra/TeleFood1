<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Testing\Fakes\Fake;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cartInfo=$this->Basket;
        $productInfo=$cartInfo->products;
        return [
            'product_name'=>$productInfo->name,
            'desctiption'=>$cartInfo->description,
            'quantity'=>$cartInfo->quantity,
            'totalprice'=>$cartInfo->total_price,
            'location'=>$this->location,
        ];
    }
}
