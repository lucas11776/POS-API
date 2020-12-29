<?php

namespace App\Http\Requests\User;

use App\Image;
use Illuminate\Foundation\Http\FormRequest;

class UploadProfilePictureRequest extends FormRequest
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
            'image' => [
                'required', 'file', 'mimes:' . implode(',', Image::ALLOWED_MIME_TYPES), 'max:' . Image::MAX_IMAGE_SIZE
            ],
        ];
    }
}
