<?php

namespace App\Http\Resources;

use App\Http\Resources\AuthenticatedUser\DealerResource;
use App\Http\Resources\AuthenticatedUser\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'dealer' => new DealerResource($this->dealer),
            'role' => RoleResource::collection($this->userRoles),
            'is_admin' => $this->is_admin,
            'crm_id' => $this->crm_id,
            'status' => $this->status,
        ];
    }
}
