<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DigitalServiceApplyRequest extends FormRequest
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
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string',
            'mobile_number' => 'required|digits_between:10,12',
            'email' => 'required|email',
            'message' => 'nullable|string',
        ];
    }
}
