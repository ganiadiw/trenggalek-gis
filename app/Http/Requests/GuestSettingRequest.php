<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestSettingRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'value_text.*' => ['sometimes', 'string'],
            'value_image.*' => ['sometimes', 'mimes:png,jpg,jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'value_image.*.mimes' => 'Format gambar didukung: png, jpg, jpeg',
        ];
    }
}
