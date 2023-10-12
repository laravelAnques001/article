<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRatingReviewRequest extends FormRequest
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
            'business_id' => 'required|exists:businesses,id',
            'rating' => ['nullable', 'numeric', 'between:0.01,5', 'regex:/^\d+(\.\d{2})?$/'],
            'review' => 'nullable|string',
        ];
    }
}
