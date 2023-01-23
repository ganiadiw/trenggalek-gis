<?php

namespace Database\Seeders;

use App\Models\TouristDestination;
use Illuminate\Database\Seeder;

class TouristDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TouristDestination::factory()->create();
    }
}
