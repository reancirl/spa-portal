<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealerResource extends JsonResource
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
            'id'                    => $this->id,
            'name'                  => $this->name,
            'code'                  => $this->code,
            'description'           => $this->description,
            'dealer_group'          => $this->when($this->dealerGroup, [
                'id' => $this->dealerGroup->id,
                'name' => $this->dealerGroup->name,
                'slug' => $this->dealerGroup->slug
            ]),
            'dealer_zone'           => $this->when($this->dealerZone, [
                'id' => $this->dealerZone->id,
                'name' => $this->dealerZone->name,
                'slug' => $this->dealerZone->slug
            ]),
            'email'                 => $this->email,
            'address_details'       => $this->address_details,
            'address_longitude'     => $this->address_longitude,
            'address_latitude'      => $this->address_latitude,
            'contact_details'       => $this->contact_details,
            'bank_details'          => $this->bank_details,
            'pic_name'              => $this->pic_name,
            'pic_email'             => $this->pic_email,
            'status'                => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
