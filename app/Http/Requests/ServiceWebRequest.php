<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceWebRequest extends FormRequest
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
            'title' => 'required|string',
            'company_name' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|image',
            'short_description' => 'nullable|string',
            'description' => 'nullable',
        ];
    }
}
