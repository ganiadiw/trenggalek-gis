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
                'color' => 'green',
                'svg_name' => 'bi bi-tsunami',
            ],
            [
                'name' => 'Wisata Konservasi',
                'slug' => str()->slug('Wisata Konservasi') . '-' . str()->random(5),
                'color' => 'lightgreen',
                'svg_name' => 'bi bi-globe-asia-australia',
            ],
            [
                'name' => 'Wisata Agro',
                'slug' => str()->slug('Wisata Agro') . '-' . str()->random(5),
                'color' => 'orange',
                'svg_name' => 'bi bi-flower3',
            ],
            [
                'name' => 'Wisata Gunung',
                'slug' => str()->slug('Wisata Gunung') . '-' . str()->random(5),
                'color' => 'darkgreen',
                'svg_name' => 'bi bi-tree-fill',
            ],
        ]);
    }
}
