<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubDistrictRequest extends FormRequest
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
            'code' => ['required', Rule::unique('sub_districts', 'code')->ignore($this->sub_district), 'max:10'],
            'name' => ['required', 'max:255'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'geojson' => ['nullable'],
            'fill_color' => ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode kecamatan harus diisi',
            'code.unique' => 'Kode kecamatan sudah terdaftar',
            'name.required' => 'Nama kecamatan harus diisi',
            'latitude.required' => 'Latitude harus diisi',
            'longitude.required' => 'Longitude harus diisi',
            'geojson' => 'File geojson harus diisi dengan format .geojson',
            'fill_color.required' => 'Warna peta harus diisi',
            'fill_color.regex' => 'Warna peta harus berupa warna Hex',
        ];
    }
}
