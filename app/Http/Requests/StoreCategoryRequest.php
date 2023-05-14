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

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Maksimal 255 karakter',
            'color.required_with' => 'Warna harus diisi jika nama icon diisi',
            'color.in' => 'Pilihan warna tidak sesuai dengan yang tersedia',
            'svg_name.required_with' => 'Nama icon harus diisi jika warna dipilih',
            'svg_name.max' => 'Maksimal 255 karakter',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => str()->slug($this->name) . '-' . str()->random(5),
        ]);
    }
}
