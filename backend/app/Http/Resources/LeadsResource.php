<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AuthenticatedUser\SalesConsultantResource;

class LeadsResource extends JsonResource
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
            'activity_source'           => $this->activity_source,
            'first_name'                => $this->first_name,
            'last_name'                 => $this->last_name,
            'mobile'                    => $this->mobile,
            'email'                     => $this->email,
            'dealer_code'               => $this->dealer_code,
            'dealer_id'                 => $this->dealer_id,
            'model_name'                => $this->model_name,
            'variant_name'              => $this->variant_name,
            'variant_id'                => $this->variant_id,
            'uploaded_at'               => $this->uploaded_at,
            'accepted_at'               => $this->accepted_at,
            'color'                     => $this->color,
            'color_id'                  => $this->color_id,
            'assigned_sc_user'          => new SalesConsultantResource($this->assignedSC),
            'sc_assigned_at'            => $this->sc_assigned_at,
            'province'                  => $this->province,
            'barangay'                  => $this->barangay,
            'zipcode'                   => $this->zipcode,
            'municipality'              => $this->municipality,
            'street'                    => $this->street,
            'preferred_communication'   => $this->preferred_communication,
            'action'                    => $this->action,
            'created_by_user_id'        => $this->created_by_user_id,
            'updated_by_user_id'        => $this->updated_by_user_id,
        ];
    }
}
