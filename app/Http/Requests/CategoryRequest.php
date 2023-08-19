<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            // 'parent_id' => ['nullable', Rule::exists('categories', 'id')->where('deleted_at', null)],
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|min:3',
            'description' => 'nullable|min:3',
            'image' => 'nullable|image',
        ];     

        return $rules;
    }
}
