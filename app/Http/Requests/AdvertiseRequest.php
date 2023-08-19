<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdvertiseRequest extends FormRequest
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
        $rules = [
            'article_id' => 'required|exists:articles,id',
            'target' => 'required|in:0,1',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'redis' => 'nullable|numeric',
            'budget' => 'nullable|numeric',

        ];
        if ($this->is('api/*')) {
            $rules['start_date'] = 'nullable|date_format:Y-m-d H:i:s';
            $rules['end_date'] = 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date';
        } else {
            $rules['start_date'] = 'nullable|date_format:Y-m-d\TH:i';
            $rules['end_date'] = 'nullable|date_format:Y-m-d\TH:i|after_or_equal:start_date';
        }
        return $rules;

    }
}
