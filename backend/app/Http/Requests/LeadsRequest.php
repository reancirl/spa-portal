<?php

namespace App\Http\Requests;

use App\Models\UploadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeadsRequest extends FormRequest
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
            'assigned_sc_user_id' => 'sometimes|exists:users,id',
            'street'              => 'sometimes|string|max:255',
            'province' => 'sometimes|string|max:255',
            'municipality' => 'sometimes|string|max:255',
            'barangay' => 'sometimes|string|max:255',
            'zipcode' => 'sometimes|string|max:255',
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
