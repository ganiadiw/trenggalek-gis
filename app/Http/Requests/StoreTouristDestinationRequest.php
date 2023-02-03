<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreTouristDestinationRequest extends FormRequest
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
            'name' => ['required'],
            'slug' => ['required'],
            'tourist_destination_category_id' => ['required'],
            'sub_district_id' => ['required'],
            'address' => ['required'],
            'manager' => ['required'],
            'distance_from_city_center' => ['required'],
            'transportation_access' => ['required'],
            'facility' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'description' => ['required'],
            'media_files' => ['nullable'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name) . '-' . Str::random(5),
        ]);
    }
}
