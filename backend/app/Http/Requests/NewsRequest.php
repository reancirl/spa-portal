<?php

namespace App\Http\Requests;

use App\Models\News;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'slug'  => ['required', 'string', 'max:255'],
            'image' =>  ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:255'],
            'content' =>  ['required', 'string', 'max:255'],
            'content_url' => ['required', 'string', 'max:255'],
            'dealers'  => ['required', 'string', 'max:255'],
            'precedence' => ['required', 'integer'],
            'featured' =>  ['required', 'boolean'],
            'status' => ['sometimes', 'boolean'],
            'published_at' => ['required', 'date'],
        ];
    }
}
