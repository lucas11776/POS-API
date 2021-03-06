<?php

namespace App\Http\Requests\Authentication;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'required', 'string'
            ],
            'password' => [
                'required', 'string', 'min:6', 'max:20'
            ]
        ];
    }
}
