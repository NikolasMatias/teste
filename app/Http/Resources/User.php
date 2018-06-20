<?php

namespace FederalSt\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class User extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'cpf' => $this->cpf,
            'api_token' => $this->when((Route::current()->uri === '/login' ||
                Route::current()->uri === '/api/login'), $this->api_token),
            'vehicles' => Vehicle::collection($this->whenLoaded('vehicles')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
