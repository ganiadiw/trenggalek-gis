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
            'color' => ['required_with:svg_name', Rule::in([
                'red',
                'darkred',
                'lightred',
                'orange',
                'beige',
                'green',
                'darkgreen',
                'lightgreen',
                'blue',
                'darkblue',
                'lightblue',
                'purple',
                'darkpurple',
                'pink',
                'cadetblue',
                'white',
                'gray',
                'lightgray',
                'black',
            ])],
            'svg_name' => ['required_with:color', 'max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Kategori',
            'color' => 'Warna',
            'svg_name' => 'Nama SVG Icon',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => str()->slug($this->name) . '-' . str()->random(5),
        ]);
    }
}
