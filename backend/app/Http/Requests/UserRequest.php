<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name'        => ['sometimes', 'string', 'max:255'],
            'last_name'         => ['sometimes', 'string', 'max:255'],
            'email'             => ['sometimes', 'email', 'unique:users', 'max:255'],
            'password'          => ['sometimes', 'string', 'max:255'],
            'crm_id'            => ['sometimes'],
            'dealer_id'         => ['required', 'exists:dealers,id'],
            'status'            => ['sometimes', 'boolean'],
            'role'              => ['sometimes', 'string'],
        ];
    }
}
