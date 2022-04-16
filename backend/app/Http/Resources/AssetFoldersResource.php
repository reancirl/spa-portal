<?php

namespace App\Http\Resources;

use App\Http\Resources\Assets\CategoriesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetFoldersResource extends JsonResource
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
            'name' => $this->name,
            'count' => $this->count,
            'description'  => $this->description,
            'status'  => $this->status,
            'precedence'  => $this->precedence, 
            'category'  => new CategoriesResource($this->category), 
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at
        ];
    }
}
