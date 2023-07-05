<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'max:255'],
            'marker_text_color' => ['required_with:custom_marker'],
            'custom_marker' => ['required_with:marker_text_color', 'image', 'mimes:png'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Kategori',
            'marker_text_color' => 'Warna Teks',
            'custom_marker' => 'Icon Marker Kustom',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => str()->slug($this->name) . '-' . str()->random(5),
        ]);
    }
}
