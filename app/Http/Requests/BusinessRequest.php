<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
            'business_name' => 'required|string',
            'gst_number' => 'nullable|gst',
            'service_id' => 'nullable|exists:services,id',
            'year' => ['nullable', 'date_format:Y', 'before_or_equal:' . date('Y')],
            'start_time' => 'nullable|date_format:H:i:s',
            'end_time' => 'nullable|date_format:H:i:s|after_or_equal:start_time',
            'amenities' => 'nullable|string',
            'website' => 'nullable|string|url',
            'people_search' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
        ];
    }
}
