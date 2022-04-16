<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if (auth()->user()->dealer_id) {
            return [
                'assigned_sc_user_id'           => 'sometimes|exists:users,id',
                'sc_assigned_at'                => 'sometimes|date',
                'status'                        => 'sometimes|string|max:255',
                'action'                        => 'sometimes|string|max:255',
                'source'                        => 'sometimes|string|max:255',
            ];
        } else {
            return [
                'customer_id'       => 'sometimes|string|max:255',
                'title'             => 'sometimes|string|max:255',
                'first_name'        => 'sometimes|string|max:255',
                'last_name'         => 'sometimes|string|max:255',
                'birthdate'         => 'sometimes|date',
                'province'          => 'sometimes|string|max:255',
                'municipality'      => 'sometimes|string|max:255',
                'zipcode'           => 'sometimes|string|max:255',
                'barangay'          => 'sometimes|string|max:255',
                'street'            => 'sometimes|string|max:255',
                'mobile'            => 'sometimes|string|max:255',
                'preferred_communication'       => 'sometimes|string|max:255',
                'email'                         => 'sometimes|email|max:255',
                'dealer_id'                     => 'sometimes|exists:dealers,id',
                'dealer_code'                   => 'sometimes|string|exists:dealers,code|max:255',
                'model_name'                    => 'sometimes|string|max:255',
                'variant_code'                  => 'sometimes|string|exists:variants,code|max:255',
                'variant_id'                    => 'sometimes|exists:variants,id',
                'color_name'                    => 'sometimes|string|max:255',
                'inquiry_date'                  => 'sometimes|date',
                'assigned_sc_user_id'           => 'sometimes|exists:users,id',
                'sc_assigned_at'                => 'sometimes|date',
                'status'                        => 'sometimes|string|max:255',
                'action'                        => 'sometimes|string|max:255',
                'source'                        => 'sometimes|string|max:255',
            ];
        }
    }
}
