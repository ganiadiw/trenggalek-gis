<?php

namespace Database\Seeders;

use App\Models\TouristDestinationCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouristDestinationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tourist_destination_categories')->insert([
            [
                'name' => 'Wisata Pantai',
            ],
            [
                'name' => 'Wisata Pertanian',
            ],
            [
                'name' => 'Wisata Cagar Alam',
            ],
            [
                'name' => 'Wisata Ziarah',
            ],
        ]);
    }
}
