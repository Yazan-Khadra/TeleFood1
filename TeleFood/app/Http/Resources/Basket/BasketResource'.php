<?php

namespace App\Http\Resources\Basket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      
        $name=$this->products->name;
        $image_url=$this->product->image_url;
        return [
                'name'=>$name,
                'image_url'=>$image_url,
                'size'=>$this->size,
                'description'=>$this->description,
                'quantity'=>$this->quantity,
                'total_price'=>$this->total_price  ];
    }
}
