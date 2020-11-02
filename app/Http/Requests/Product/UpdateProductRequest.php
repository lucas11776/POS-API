<?php

namespace App\Http\Requests\Product;

use App\Image;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
                'nullable', 'numeric', 'exists:products_categories,id'
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
            'in_stock' => [
                'required', 'numeric'
            ],
            'barcode' => [
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
            'words' => 'The :attributes must have maximum of 1500 characters.'
        ];
    }
}
