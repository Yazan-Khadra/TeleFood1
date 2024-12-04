<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //all store info
        return ['store_name'=>$this->store_name,
                'description'=>$this->description,
                'image_url'=>$this->image_url,
                'rate'=>$this->rate];
    }
}
