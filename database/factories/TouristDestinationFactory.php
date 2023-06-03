<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'category_id' => 1,
            'name' => 'Pantai Konang',
            'slug' => 'pantai-konang-12345',
            'manager' => 'LDMH',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner ikan bakar</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir',
            'cover_image_name' => 'image.jpg',
            'cover_image_path' => '/cover_images/image.jpg',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ];
    }
}
