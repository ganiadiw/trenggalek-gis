<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTouristDestinationRequest extends FormRequest
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
            'category_id' => ['required'],
            'sub_district_id' => ['required'],
            'address' => ['required', 'max:255'],
            'manager' => ['required', 'max:255'],
            'distance_from_city_center' => ['required', 'max:10'],
            'transportation_access' => ['required'],
            'facility' => ['required'],
            'cover_image' => ['sometimes', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'latitude' => ['required', 'max:50'],
            'longitude' => ['required', 'max:50'],
            'description' => ['required'],
            'media_files' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama destinasi wisata harus diisi',
            'name.max' => 'Jumlah karakter maksimal 255',
            'tourist_destination_category_id.required' => 'Pilih kategori destinasi wisata',
            'sub_district_id.required' => 'Kecamatan harus diisi',
            'address.required' => 'Alamat harus diisi',
            'address.max' => 'Jumlah karakter maksimal 255',
            'manager.required' => 'Pengelola harus diisi',
            'manager.max' => 'Jumlah karakter maksimal 255',
            'distance_from_city_center.required' => 'Jarak harus diisi',
            'distance_from_city_center.max' => 'Jumlah karakter maksimal 10',
            'transportation_access.required' => 'Akses transportasi harus diisi',
            'facility.required' => 'Fasilitas harus diisi',
            'cover_image.image' => 'Foto sampul harus berupa gambar',
            'cover_image.mimes' => 'Format gambar tidak didukung, gunakan .png, .jpg atau .jpeg',
            'cover_image.max' => 'Foto sampul maksimal berukuran 2048 KB',
            'latitude.required' => 'Latitude harus diisi',
            'latitude.max' => 'Jumlah karakter maksimal 50',
            'longitude.required' => 'Longitude harus diisi',
            'longitude.max' => 'Jumlah karakter maksimal 50',
            'description.required' => 'Deskripsi harus diisi',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->sub_district_id != null) {
            $this->merge([
                'sub_district_id' => json_decode($this->sub_district_id)->id,
            ]);
        }
    }
}
