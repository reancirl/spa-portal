<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AuthenticatedUser\SalesConsultantResource;
use App\Models\QuotationStatus;
use App\Models\QuotationAction;

class QuotationResource extends JsonResource
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
            'id'                    =>  $this->id,
            'customer_id'           =>  $this->customer_id,
            'title'                 =>  $this->title,
            'first_name'            =>  $this->first_name,
            'last_name'             =>  $this->last_name,
            'birthdate'             =>  $this->birthdate,
            'province'              =>  $this->province,
            'municipality'          =>  $this->municipality,
            'zipcode'               =>  $this->zipcode,
            'barangay'              =>  $this->barangay,
            'street'                =>  $this->street,
            'mobile'                =>  $this->mobile,
            'email'                 =>  $this->email,
            'dealer_id'             =>  $this->dealer_id,
            'dealer_name'           =>  $this->dealer_name,
            'model_name'            =>  $this->model_name,
            'variant_id'            =>  $this->variant_id,
            'variant_name'          =>  $this->variant_name,
            'color_name'            =>  $this->color_name,
            'color_id'              =>  $this->color_id,
            'assigned_sc_user'      => new SalesConsultantResource($this->assignedSC),
            'sc_assigned_at'        =>  $this->sc_assigned_at,
            'status'                =>  $this->when($this->status, [
                'code'  => $this->status,
                'label' => QuotationStatus::$statusTexts[$this->status],
                'description' => QuotationStatus::$statusDescriptions[$this->status]
            ]),
            'action'                => $this->when($this->action, [
                'code' =>  $this->action,
                'label' => QuotationAction::$statusTexts[$this->action],
                'description' => QuotationAction::$statusDescriptions[$this->action],
            ]),
            'source'                =>  $this->source,
            'created_by_user_id'    =>  $this->created_by_user_id,
            'updated_by_user_id'    =>  $this->updated_by_user_id,
            'document'              =>  $this->when($this->document, url("/quotation/{$this->id}/download")),
            'created_at'            =>  $this->created_at,
            'variant'               => $this->when($this->variant, [
                'id'   => $this->variant->id,
                'name' => $this->variant->name,
            ]),
            'color'                 => $this->when($this->color, [
                'id'   => $this->color->id,
                'name' => $this->color->name,
            ]),
        ];
    }
}
