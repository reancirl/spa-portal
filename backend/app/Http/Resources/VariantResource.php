<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
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
            'model'             => $this->when($this->model, [
                'id' => $this->model->id,
                'name' =>  $this->model->name,
                'code' => $this->model->code,
            ]),
            'year'              => $this->when($this->year, [
                'id' => $this->year->id,
                'name' =>  $this->year->name,
                'code' => $this->year->code,
            ]),
            'name'              => $this->name,
            'alias'             => $this->alias,
            'long_name'         => $this->long_name,
            'code'              => $this->code,
            'price'             => $this->price,
            'status'            => $this->status,
            'created_by_user'   => $this->user,
            'updated_by_user'   => $this->user,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
