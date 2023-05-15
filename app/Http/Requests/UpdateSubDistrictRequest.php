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
            'geojson' => ['nullable', 'file', 'mimetypes:application/json'],
            'geojson_text_area' => ['nullable'],
            'fill_color' => ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'],
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'Kode Kecamatan',
            'name' => 'Nama Kecamatan',
            'latitude' => 'Latitude / Garis Lintang',
            'longitude' => 'Longitude / Garis Bujur',
            'geojson' => 'File Peta Geojson',
            'geojson_text_area' => 'Kode Koordinat Peta Geojson',
            'fill_color' => 'Warna Peta',
        ];
    }
}
