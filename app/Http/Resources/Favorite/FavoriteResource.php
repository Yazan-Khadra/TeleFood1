<?php

namespace App\Http\Resources\Favorite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //show products info
        return ['product_name'=>$this->product_name,
                'imag_url'=>$this->image_url,
                'description'=>$this->description,
                'price'=>$this->price];
    }
}
