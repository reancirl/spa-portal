<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AuthenticatedUser\SalesConsultantResource;

class InquiryResource extends JsonResource
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
            'id'                      => $this->id,
            'title'                   => $this->title,
            'first_name'              => $this->first_name,
            'last_name'               => $this->last_name,
            'birthdate'               => $this->birthdate,
            'province'                => $this->province,
            'municipality'            => $this->municipality,
            'zipcode'                 => $this->zipcode,
            'barangay'                => $this->barangay,
            'street'                  => $this->street,
            'mobile'                  => $this->mobile,
            'preferred_communication' => $this->preferred_communication,
            'email'                   => $this->email,
            'dealer_code'             => $this->dealer_code,
            'model_name'              => $this->model_name,
            'variant_code'            => $this->variant_code,
            'color_name'              => $this->color_name,
            'inquiry_date'            => $this->inquiry_date,
            'assigned_sc_user'        => new SalesConsultantResource($this->assignedUser),
            'sc_assigned_at'          => $this->sc_assigned_at,
            'status'                  => $this->status,
            'action'                  => $this->action,
            'source'                  => $this->source,
            'updated_at'              => $this->updated_at,
            'created_at'              => $this->created_at,
            'created_by_user_id'      => $this->created_by_user_id,
            'updated_by_user_id'      => $this->updated_by_user_id,
        ];
    }
}
