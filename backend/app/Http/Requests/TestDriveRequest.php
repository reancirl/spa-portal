<?php

namespace App\Http\Requests;

use App\Models\UploadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestDriveRequest extends FormRequest
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
            'assigned_sc_user_id'      => 'sometimes|exists:users,id',
            'action'                   => 'sometimes|string|max:255',
            'status' => [
                'sometimes',
                Rule::in([
                    UploadStatus::STAT_PENDING,
                    UploadStatus::STAT_SENT,
                    UploadStatus::STAT_BOOKEND,
                    UploadStatus::STAT_SALES,
                    UploadStatus::STAT_CLOSE
                ]),
            ],
        ];
    }
}
