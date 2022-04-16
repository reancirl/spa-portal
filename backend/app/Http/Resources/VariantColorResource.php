<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantColorResource extends JsonResource
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
            'id'              => $this->id,
            'variant_id'      => $this->variant_id,
            'name'            => $this->name,
            'price'           => $this->price,
            'pricing'         => $this->pricing,
            'code'            => $this->code,
            'long_name'       => $this->long_name,
            'status'          => $this->status,
            'created_by_user' => $this->user,
            'updated_by_user' => $this->user,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'color'           => $this->when($this->color, [
                'id' => $this->color->id,
                'name' =>  $this->color->name,
                'code' => $this->color->code,
            ]),
            'variant'         => $this->when($this->variant, [
                'id' => $this->variant->id,
                'name' =>  $this->variant->name,
                'code' => $this->variant->code,
                'status' => $this->variant->status,
                'price' => $this->variant->price,
            ]),
        ];
    }
}
