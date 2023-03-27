<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouristDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tourist_destinations')->insert([
            [
                'sub_district_id' => 1,
                'category_id' => 1,
                'name' => 'Pantai Konang',
                'slug' => str()->slug('Pantai Konang') . '-' . str()->random(5),
                'manager' => 'LDMH',
                'address' => 'Desa Nglebeng, Kecamatan Panggul',
                'description' => '<p>Terkenal dengan keindahan pantai dan kuliner ikan bakar</p>',
                'distance_from_city_center' => '56 KM',
                'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
                'facility' => 'MCK, Mushola, Lahan Parkir',
                'cover_image_name' => 'image.jpg',
                'cover_image_path' => '/storage/app/public/images/cover_image/image.jpg',
                'latitude' => -8.27466803,
                'longitude' => 111.45297354,
            ],
        ]);
    }
}
