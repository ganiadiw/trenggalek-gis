<?php

namespace Database\Seeders;

use App\Models\TouristDestinationCategory;
use Illuminate\Database\Seeder;

class TouristDestinationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TouristDestinationCategory::factory()->create();

        collect([
            [
                'name' => 'Wisata Pertanian',
            ],
            [
                'name' => 'Wisata Cagar Alam',
            ],
            [
                'name' => 'Wisata Ziarah',
            ],
        ])->each(function ($category) {
            TouristDestinationCategory::create($category);
        });
    }
}
