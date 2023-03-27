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
            ],
            [
                'name' => 'Wisata Bahari',
                'slug' => str()->slug('Wisata Bahari') . '-' . str()->random(5),
            ],
            [
                'name' => 'Wisata Religi',
                'slug' => str()->slug('Wisata Religi') . '-' . str()->random(5),
            ],
            [
                'name' => 'Wisata Agro',
                'slug' => str()->slug('Wisata Agro') . '-' . str()->random(5),
            ],
            [
                'name' => 'Wisata Gunung',
                'slug' => str()->slug('Wisata Gunung') . '-' . str()->random(5),
            ],
        ]);
    }
}
