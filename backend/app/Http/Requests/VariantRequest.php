<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class VariantRequest extends FormRequest
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
        $id = $this->route('variant');

        return [
            'model_id'  => ['sometimes', 'exists:models,id'],
            'year_id'           => ['sometimes', 'exists:model_years,id'],
            'name'              => ['string', 'sometimes', 'max:255'],
            'code'              => ['sometimes', 'string', 'unique:variants,code,' . $id, 'max:255'],
            'price'             => ['numeric'],
            'status'            => ['sometimes', 'boolean']
        ];
    }
}
