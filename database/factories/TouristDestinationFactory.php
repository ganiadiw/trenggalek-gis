<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TouristDestination>
 */
class TouristDestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sub_district_id' => 1,
            'tourist_destination_category_id' => 1,
            'name' => 'Pantai Konang',
            'slug' => Str::slug('Pantai Konang') . '-' . Str::random(5),
            'manager' => 'LDMH',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner ikan bakar</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir',
            'cover_image_name' => 'image.jpg',
            'cover_image_path' => '/storage/app/publi/images/cover_image/image.jpg',
            'latitude' => '-8.274668036926231',
            'longitude' => '111.4529735413945',
        ];
    }
}
