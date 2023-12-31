<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryRequest extends FormRequest
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
            'business_id' => 'required_without:keys|exists:businesses,id',
            'keys' => 'required_without:business_id|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile_number' => 'required|digits_between:10,12',
        ];
    }
}
