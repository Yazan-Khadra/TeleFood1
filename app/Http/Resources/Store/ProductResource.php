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
        $store= $this->Store->name;
        return [
            'product_id'=>$this->id,
            'store_name'=>$store,
            'product_name'=>$this->name,
            'description'=>$this->description,
            'price'=>$this->price,
            'imge_url'=>$this->image_url
        ];
    }
}
