<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ArticleWebRequest extends FormRequest
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
            // 'link' => 'required|string',
            'link' => ['required','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'tags' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'image_type' => 'nullable|in:0,1,2',
            // 'media' => 'nullable|file',
            'media' => 'nullable|file|mimes:jpeg,jpg,png,bmp,gif,svg,mp4,ogx,oga,ogv,ogg,webm,video/*',
            'thumbnail' => 'nullable|string',
            'status' => 'nullable|in:In-Review,Approved,Rejected',
            'category_id' => 'required|array',
            'category_id.*' => ['required', Rule::exists('categories', 'id')->whereNull('deleted_at')]
        ];

    }
}
