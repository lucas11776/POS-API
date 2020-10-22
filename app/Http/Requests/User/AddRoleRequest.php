<?php

namespace App\Http\Requests\User;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddRoleRequest extends FormRequest
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
            'name' => [
                'required', 'string', Rule::in(Role::ROLES), function ($key, $value, $fail) {
                    if($this->user->roles()->where([$key => $value])->exists()) {
                        $fail("The user already contains the role {$value}");
                    }
                }
            ]
        ];
    }
}
