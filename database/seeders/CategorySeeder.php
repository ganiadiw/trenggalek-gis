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
                'hex_code' => '#71ae26',
            ],
            [
                'name' => 'Wisata Konservasi',
                'slug' => str()->slug('Wisata Konservasi') . '-' . str()->random(5),
                'color' => 'lightgreen',
                'svg_name' => 'bi bi-globe-asia-australia',
                'hex_code' => '#b8f471',
            ],
            [
                'name' => 'Wisata Agro',
                'slug' => str()->slug('Wisata Agro') . '-' . str()->random(5),
                'color' => 'orange',
                'svg_name' => 'bi bi-flower3',
                'hex_code' => '#f1932f',
            ],
            [
                'name' => 'Wisata Gunung',
                'slug' => str()->slug('Wisata Gunung') . '-' . str()->random(5),
                'color' => 'darkgreen',
                'svg_name' => 'bi bi-tree-fill',
                'hex_code' => '#6f7f23',
            ],
        ]);
    }
}
