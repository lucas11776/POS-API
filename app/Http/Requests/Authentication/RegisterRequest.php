<?php

namespace App\Http\Requests\Authentication;

use App\User;
use App\Logic\RegexExpresses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->guest();
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
                'required', 'string', 'min:3', 'max:50'
            ],
            'gender' => [
                'nullable', 'string', Rule::in(['female', 'male'])
            ],
            'email' => [
                'required_if:cellphone_number,', 'string', 'email', 'unique:users'
            ],
            'cellphone_number' => [
                'required_if:email,', 'string', 'regex:' . RegexExpresses::CELLPHONE_NUMBER, Rule::unique(User::class)
            ],
            'password' => [
                'required', 'string', 'regex:' . RegexExpresses::PASSWORD, 'min:8', 'max:20', 'confirmed'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function message()
    {
        return [
            'email.unique' => 'The email address already exist in our database reset password if you forgot password.',
            'cellphone_number.unique' => 'The cellphone number already exist in our database please enter new cellphone.',
            'cellphone_number.regex' => 'The cellphone number is invalid please use your country code in your cellphone number.',
            'password.regex' => 'The password is invalid password must contain one uppercase latter, one special character
            !@#$%^& and one digit.'
        ];
    }
}
