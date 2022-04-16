<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'id'                            => $this->id,
            'title'                         => $this->title,
            'first_name'                    => $this->first_name,
            'last_name'                     => $this->last_name,
            'birthdate'                     => $this->birthdate,
            'province'                      => $this->province,
            'municipality'                  => $this->municipality,
            'zipcode'                       => $this->zipcode,
            'barangay'                      => $this->barangay,
            'street'                        => $this->street,
            'mobile'                        => $this->mobile,
            'preferred_communication'       => $this->preferred_communication,
            'email'                         => $this->email,
            'dealer_id'                     => $this->dealer_id,
            'dealer_name'                   => $this->dealer_name,
            'model_name'                    => $this->model_name,
            'variant_id'                    => $this->variant_id,
            'variant_name'                  => $this->variant_name,
            'color'                         => $this->color,
            'color_id'                      => $this->color_id,
            'pending_since_date'            => $this->pending_since_date,
            'payment_method'                => $this->payment_method,
            'assigned_sc_user'              => $this->user,
            'sc_assigned_at'                => $this->sc_assigned_at,
            'status'                        => $this->status,
            'action'                        => $this->action,
            'source'                        => $this->source,
            'reserved_at'                   => $this->reserved_at,
            'created_by_user_id'            => $this->created_by_user_id,
            'updated_by_user_id'            => $this->updated_by_user_id,

        ];
    }
}
