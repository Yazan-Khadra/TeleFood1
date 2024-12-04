<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locations=[];
        $i=0;
        foreach($this->Location as $location){
            $locations[$i]=['governorate'=>$location->Governorate->name,'location'=>$location->location];
            $i++;
        }
        return [
            'store_id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'rate'=>$this->rate,
            'image_url'=>$this->image_url,
            'locations'=>$locations,
            
        ];
    }
}
