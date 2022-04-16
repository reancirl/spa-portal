<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealerZoneRequest extends FormRequest
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
        $id = $this->route('zone');

        return [
            'name'          => ['sometimes', 'string', 'max:255'],
            'description'   => ['sometimes', 'string', 'max:255'],
            'slug'          => ['sometimes', 'unique:dealer_zones,slug,' . $id, 'string', 'max:255'],
            'status'        => ['sometimes', 'boolean'],
        ];
    }
}
