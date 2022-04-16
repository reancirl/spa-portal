<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestDriveResource extends JsonResource
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
            'id'                        => $this->id,
            'customer_id'               => $this->customer_id,
            'title'                     => $this->title,
            'first_name'                => $this->first_name,
            'last_name'                 => $this->last_name,
            'birthdate'                 => $this->birthdate,
            'province'                  => $this->province,
            'municipality'              => $this->imunicipalityd,
            'zipcode'                   => $this->zipcode,
            'barangay'                  => $this->barangay,
            'street'                    => $this->street,
            'mobile'                    => $this->mobile,
            'email'                     => $this->email,
            'preferred_communication'   => $this->preferred_communication,
            'dealer_id'                 => $this->dealer_id,
            'dealer_code'               => $this->dealer_code,
            'model_name'                => $this->model_name,
            'variant_id'                => $this->variant_id,
            'variant_name'              => $this->variant_name,
            'color_name'                => $this->color_name,
            'test_drive_date'           => $this->test_drive_date,
            'assigned_sc_user_id'       => $this->assigned_sc_user_id,
            'sc_assigned_at'            => $this->sc_assigned_at,
            'status'                    => $this->status,
            'action'                    => $this->action,
            'source'                    => $this->source,
            'created_by_user_id'        => $this->created_by_user_id,
            'updated_by_user_id'        => $this->updated_by_user_id,
        ];
    }
}
