<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'code'              => $this->code,
            'description'       => $this->description,
            'image'             => $this->image,
            'status'            => $this->status,
            'created_by_user'   => $this->user,
            'updated_by_user'   => $this->user,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
