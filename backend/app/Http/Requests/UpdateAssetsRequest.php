<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAssetsRequest extends FormRequest
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
            'category_id' => ['required', 'exists:asset_categories,id'],
            'folder_id' => ['required', 'exists:asset_folders,id'],
            // 'file' => ['image'],
            // 'description' => ['sometimes', 'string'],
            'published_at' => ['sometimes', 'date_format:Y-m-d H:i:s', 'after:' . now()->format('Y-m-d H:i:s')],
            //'expired_at' => ['required', 'date', 'after:' . now()->format('Y-m-d')],
            'status' => ['boolean'],
            'precedence' => ['integer'],
            'dealers' => ['string'],
        ];
    }
}
