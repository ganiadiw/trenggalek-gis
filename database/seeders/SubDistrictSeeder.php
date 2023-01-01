<?php

namespace Database\Seeders;

use App\Models\SubDistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $sql = file_get_contents(database_path().'/seeders/sql_files/sub_district.sql');
        // DB::unprepared($sql);
        SubDistrict::create([
            'code' => '3503000',
            'name' => 'sample',
            'latitude' => '-8.243122474284371',
            'longitude' => '111.4543148316443',
            'geojson_path' => 'public/geojson/PA-lkdYD-3503010.geojson',
            'geojson_name' => 'PA-lkdYD-3503010.geojson',
            'fill_color' => '#C7B35A'
        ]);
    }
}
