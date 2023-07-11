<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Wisata Pantai',
                'slug' => str()->slug('Wisata Pantai') . '-' . str()->random(5),
                'marker_text_color' => null,
                'custom_marker_name' => null,
                'custom_marker_path' => null,
            ],
            [
                'name' => 'Wisata Konservasi',
                'slug' => str()->slug('Wisata Konservasi') . '-' . str()->random(5),
                'marker_text_color' => null,
                'custom_marker_name' => null,
                'custom_marker_path' => null,
            ],
            [
                'name' => 'Wisata Agro',
                'slug' => str()->slug('Wisata Agro') . '-' . str()->random(5),
                'marker_text_color' => null,
                'custom_marker_name' => null,
                'custom_marker_path' => null,
            ],
            [
                'name' => 'Wisata Gunung',
                'slug' => str()->slug('Wisata Gunung') . '-' . str()->random(5),
                'marker_text_color' => null,
                'custom_marker_name' => null,
                'custom_marker_path' => null,
            ],
        ]);
    }
}
