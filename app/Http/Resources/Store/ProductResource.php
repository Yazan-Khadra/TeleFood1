<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id'=>$this->id,
            'product_name'=>$this->name,
            'description'=>$this->description,
            'price'=>$this->price,
            'imge_url'=>$this->image_url
        ];
    }
}
