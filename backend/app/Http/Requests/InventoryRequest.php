<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
        return [
            'variant_code'          => 'sometimes|string|exists:variants,code|max:255',
            'variant_name'          => 'sometimes|string|max:255',
            'dealer_code'           => 'sometimes|string|exists:dealers,code|max:255',
            'dealer_name'           => 'sometimes|string|max:255',
            'model_name'            => 'sometimes|string|max:255',
            'model_year'            => 'sometimes|string|max:255',
            'color_name'            => 'sometimes|string|max:255',
            'color_code'            => 'sometimes|string|exists:colors,code|max:255',
        ];
    }
}
