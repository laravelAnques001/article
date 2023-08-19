<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PollsRequest extends FormRequest
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
            'title' => 'required|string|min:3',
            'link' => 'nullable|string|min:3',
            'description' => 'nullable|min:3',
            'image' => 'nullable|image',
        ];
    }
}
