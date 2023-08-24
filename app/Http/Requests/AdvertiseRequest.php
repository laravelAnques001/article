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
            'locations' => 'nullable|string',
            'redis' => 'nullable|numeric',
            'budget' => 'nullable|numeric',
            'budget_type' => 'nullable|in:0,1',
            'ad_status' => 'nullable|in:0,1',
        ];

        if ($this->is('api/*')) {
            $rules['start_date'] = 'nullable|date_format:Y-m-d H:i:s';
            $rules['end_date'] = 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date';
        }

        if ($this->is('api/advertise')) {
            $rules['target'] = 'required|in:0,1';
            $rules['article_id'] = 'required|exists:articles,id';
        } elseif ($this->is('api/edit-advertise/*')) {
            $rules['target'] = 'nullable|in:0,1';
            $rules['article_id'] = 'nullable|exists:articles,id';
        } else {
            $rules['article_id'] = 'required|exists:articles,id';
            $rules['target'] = 'required|in:0,1';
            $rules['status'] = 'nullable|in:Pending,Published,Rejected';
            $rules['start_date'] = 'nullable|date_format:Y-m-d\TH:i';
            $rules['end_date'] = 'nullable|date_format:Y-m-d\TH:i|after_or_equal:start_date';
        }
        return $rules;

    }
}
