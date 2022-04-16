<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealerRequest extends FormRequest
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
        $id = $this->route('dealer');

        return [
            'name'                  => ['sometimes', 'string', 'max:255'],
            'description'           => ['sometimes', 'string', 'max:255'],
            'code'                  => ['sometimes', 'unique:dealers,code,' . $id, 'string', 'max:255'],
            'status'                => ['sometimes', 'boolean'],
            'email'                 => ['sometimes', 'email','string'],
            'address_details'       => ['sometimes', 'string', 'max:255'],
            'address_longitude'     => ['sometimes', 'string', 'max:255'],
            'address_latitude'      => ['sometimes', 'string', 'max:255'],
            'contact_details'       => ['sometimes', 'string', 'max:255'],
            'bank_details'          => ['sometimes'],
            'pic_name'              => ['sometimes', 'string', 'max:255'],
            'pic_email'             => ['sometimes', 'email', 'string', 'max:255'],
            'status'                => ['sometimes','boolean'],
            'group_id'              => ['sometimes','exists:dealer_groups,id'],
            'zone_id'              => ['sometimes','exists:dealer_zones,id'],
        ];
    }
}
