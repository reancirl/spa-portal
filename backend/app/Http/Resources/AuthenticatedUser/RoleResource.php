<?php

namespace App\Http\Resources\AuthenticatedUser;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->role->id,
            'name' => $this->role->name,
            'slug' => $this->role->slug,
        ];
    }
}
