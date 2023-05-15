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
            'tourist_attraction_id.*' => ['nullable', 'max:255'],
            'tourist_attraction_names.*' => ['nullable', 'max:255'],
            'tourist_attraction_captions.*' => ['nullable', 'max:255'],
            'new_tourist_attraction_names.*' => ['nullable', 'max:255'],
            'new_tourist_attraction_images.*' => ['nullable', 'mimes:png,jpg'],
            'new_tourist_attraction_captions.*' => ['nullable', 'max:255'],
            'facebook_url' => 'nullable',
            'instagram_url' => 'nullable',
            'twitter_url' => 'nullable',
            'youtube_url' => 'nullable',
            'media_files' => ['nullable'],
            'deleted_tourist_attractions' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama Destinasi Wisata',
            'category_id' => 'Kategori',
            'sub_district_id' => 'Kecamatan',
            'address' => 'Alamat',
            'manager' => 'Pengelola',
            'distance_from_city_center' => 'Jarak Dari Pusat Kota',
            'transportation_access' => 'Akses Transportasi',
            'facility' => 'Fasilitas',
            'cover_image' => 'Foto Sampul',
            'latitude' => 'Latitude / Garis Lintang',
            'longitude' => 'Longitude / Garis Bujur',
            'description' => 'Deskripsi Destiansi Wisata',
            'tourist_attraction_names.*' => 'Nama Atraksi Wisata',
            'tourist_attraction_images.*' => 'Foto Atraksi Wisata',
            'tourist_attraction_captions.*' => 'Keterangan Atraksi Wisata',
            'new_tourist_attraction_names.*' => 'Nama Atraksi Wisata',
            'new_tourist_attraction_images.*' => 'Foto Atraksi Wisata',
            'new_tourist_attraction_captions.*' => 'Keterangan Atraksi Wisata',
            'facebook_url' => 'Alamat URL Facebook',
            'instagram_url' => 'Alamat URL Instragram',
            'twitter_url' => 'Alamat URL Twitter',
            'youtube_url' => 'Alamat URL Youtube',
        ];
    }
}
