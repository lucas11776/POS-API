<?php

namespace App\Http\Requests\User;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => [
                'required', 'string', 'min:3', 'max:50'
            ],
            'last_name' => [
                'required', 'min:3', 'max:50'
            ],
            'gender' => [
                'nullable', 'string', Rule::in(User::GENDER)
            ]
        ];
    }
}
