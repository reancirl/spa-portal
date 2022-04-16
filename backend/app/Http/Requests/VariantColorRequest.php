<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class VariantColorRequest extends FormRequest
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
     * Return JSON response the validated fields.
     *
     * @return array
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('color');
        
        return [
            'variant_id'    => ['sometimes', 'exists:variants,id'],
            'color_id'      => ['sometimes', 'exists:colors,id'],
            'name'          => ['sometimes', 'string', 'max:255'],
            'price'         => ['sometimes', 'numeric'],
            'pricing'       => ['required', Rule::in(['inherit', 'custom'])],
            'code'          => ['sometimes', 'string', 'unique:variant_colors,code,' . $id, 'max:255'],
            'status'        => ['required', 'boolean']
        ];
    }
}
