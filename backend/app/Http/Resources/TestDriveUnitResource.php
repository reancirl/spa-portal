<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestDriveUnitResource extends JsonResource
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
            'dealer_id' => $this->dealer_id,
            'dealer_code' => $this->dealer_code,
            'model_name' => $this->model_name,
            'variant_name' => $this->variant_name,
            'model_year' => $this->model_year,
            'color_name' => $this->color_name,
            'quantity' => $this->quantity,
            'created_by_user_id' => $this->created_by_user_id,
            'updated_by_user_id' => $this->updated_by_user_id,
        ];
    }
}
