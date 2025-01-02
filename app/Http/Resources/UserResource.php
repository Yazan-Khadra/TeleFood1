<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'image'=>$this->image_url,
            'location'=>$this->location,
            'location_details'=>$this->location_details,
            'mobile'=>$this->mobile,
            'fcm_token'=>$this->fcm_token,
        ];
    }
}
