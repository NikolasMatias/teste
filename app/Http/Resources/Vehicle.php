<?php

namespace FederalSt\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Vehicle extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'plate' => $this->plate,
            'brand' => $this->brand,
            'vehicle_model' => $this->vehicle_model,
            'year' => $this->year,
            'renavam' => $this->renavam,
            'owner' => new User($this->whenLoaded('owner')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
