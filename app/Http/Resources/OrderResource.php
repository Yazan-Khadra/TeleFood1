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
        $driver_info=$this->Driver;
        return [
            'location'=>$this->location,
            'driver_name'=>$driver_info->driver_name,
            'motorcycle_number'=>$driver_info->motorcycle_number,
            'order_id'=>$this->order_id,
            'time to arrive'=>$this->arrivial_time,
        ];
    }
}
