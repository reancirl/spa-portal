<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
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
        if($this->isMethod('post')){
            return [
                'customer_id'           => 'sometimes|string|max:255',
                'title'                 => 'sometimes|string|max:255',
                'first_name'            => 'sometimes|string|max:255',
                'last_name'             => 'sometimes|string|max:255',
                'birthdate'             => 'sometimes|max:255',
                'province'              => 'sometimes|string|max:255',
                'municipality'          => 'sometimes|string|max:255',
                'zipcode'               => 'sometimes|string|max:255',
                'barangay'              => 'sometimes|string|max:255',
                'street'                => 'sometimes|string|max:255',
                'mobile'                => 'sometimes|string|max:255',
                'email'                 => 'sometimes|email|max:255',
                'dealer_id'             => 'sometimes|exists:dealers,id',
                'dealer_name'           => 'sometimes|string|max:255',
                'model_name'            => 'sometimes|string|max:255',
                'variant_id'            => 'sometimes|exists:variants,id',
                'variant_name'          => 'sometimes|string|max:255',
                'color_name'            => 'sometimes|string|max:255',
                'color_id'              => 'sometimes|exists:colors,id',
                'assigned_sc_user_id'   => 'sometimes|exists:users,id',
                'status'                => 'sometimes|string|max:255',
                'action'                => 'sometimes|string|max:255',
                'source'                => 'sometimes|string|max:255',
                'created_by_user_id'    => 'sometimes|exists:users,id',
                'updated_by_user_id'    => 'sometimes|exists:users,id',
                'document'              => 'sometimes|string|max:255',
            ];
        }
        else{
            return [
                'assigned_sc_user_id'   => 'sometimes|exists:users,id',
                'status'                => 'sometimes|string|max:255',
                'action'                => 'sometimes|string|max:255',
            ];
        }
    }
}
