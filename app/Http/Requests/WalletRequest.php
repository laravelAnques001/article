<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
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
            'date' => 'nullable|date_format:Y-m-d\TH:i',
            'user_id' => 'required|exists:users,id',
            'transaction_id' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_response' => 'nullable|string',
        ];
    }
}
