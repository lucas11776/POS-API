<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAddressRequest extends FormRequest
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
            'address' => [
                'nullable', 'string', 'min:5', 'max:100'
            ],
            'country_id' => [
                'nullable', 'numeric', Rule::exists('countries', 'id')
            ],
            'city' => [
                'nullable', 'string', 'min:3', 'max:50'
            ],
            'postal_code' => [
                'nullable', 'digits_between:4,10'
            ]
        ];
    }
}
