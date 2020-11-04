<?php

namespace App\Http\Requests\Service;

use App\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateServiceRequest extends FormRequest
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
            'category_id' => [
                'nullable', Rule::exists('products_categories', 'id')
            ],
            'image' => [
                'required', 'file', 'mimes:' . implode(',', Image::ALLOWED_MIME_TYPES), 'max:' . Image::MAX_IMAGE_SIZE
            ],
            'images' => [
                'nullable', 'array'
            ],
            'images.*' => [
                'file', 'mimes:' . implode(',', Image::ALLOWED_MIME_TYPES), 'max:' . Image::MAX_IMAGE_SIZE
            ],
            'name' => [
                'required', 'string', 'min:5', 'max:50'
            ],
            'price' => [
                'required', 'numeric'
            ],
            'discount' => [
                'nullable', 'numeric'
            ],
            'description' => [
                'required', 'string', 'words:1500'
            ]
        ];
    }

    public function messages()
    {
        return [
            'words' => 'The :attribute most not exceed maximum of 1500 words.'
        ];
    }
}
