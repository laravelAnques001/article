<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
            'title' => 'required|string',
            'link' => 'nullable|string',
            'tags' => 'nullable|string|min:3',
            'description' => 'nullable|string|min:3',
            'image_type' => 'nullable|in:0,1,2',
            // 'media' => 'nullable|file',
            // 'media' => 'nullable|file|mimes:jpeg,jpg,png,bmp,gif,svg,mp4,ogx,oga,ogv,ogg,webm,video/*',
            'media' => 'nullable|string',
            'status' => 'nullable|in:In-Review,Approved,Rejected',
        ];
        if ($this->is('article')) {
            $rules['category_id'] = ['required', Rule::exists('categories', 'id')->whereNull('deleted_at')];
        } else {
            $rules['category_id'] = ['nullable', Rule::exists('categories', 'id')->whereNull('deleted_at')];
        }
        return $rules;
    }
}
