<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'id'                   => $this->id,
            'dealer_code'          => $this->dealer_code,
            'dealer_name'          => $this->dealer_name,
            'variant_code'         => $this->variant_code,
            'variant_name'         => $this->variant_name,
            'model_name'           => $this->model_name,
            'model_year'           => $this->model_year,
            'color_name'           => $this->color_name,
            'color_code'           => $this->color_code,
            'quantity'             => $this->quantity,
            'price'                => $this->price, //TODO: Get Price
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            'created_by_user_id'   => $this->created_by_user_id,
            'updated_by_user_id'   => $this->updated_by_user_id,
        ];
    }
}
