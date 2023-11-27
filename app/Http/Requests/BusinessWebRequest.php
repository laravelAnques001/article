<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessWebRequest extends FormRequest
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
            'service_id.*' => 'nullable|exists:services,id',
            'aminity_id.*' => 'nullable|exists:aminities,id',
            'year' => 'nullable|date_format:Y',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            // 'amenities' => 'nullable|string',
            'website' => 'nullable|string|url',
            'people_search' => 'nullable|string',
            'description' => 'nullable|string',
            'business_number' => 'required|unique:users,email',
            'business_email' => 'required|unique:users,mobile_number',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
