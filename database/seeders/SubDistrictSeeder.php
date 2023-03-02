<?php

namespace Database\Seeders;

use App\Models\SubDistrict;
use Illuminate\Database\Seeder;

class SubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubDistrict::create([
            'code' => 3503010,
            'name' => 'KECAMATAN PANGGUL',
            'latitude' => -8.24312247,
            'longitude' => 111.45431483,
            'geojson_path' => 'public/geojson/lkdYD-3503010.geojson',
            'geojson_name' => 'lkdYD-3503010.geojson',
            'fill_color' => '#C7B35A',
        ]);

        SubDistrict::create([
            'code' => 3503020,
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => -8.24312247,
            'longitude' => 111.45431483,
            'geojson_path' => 'public/geojson/lkdYD-3503020.geojson',
            'geojson_name' => 'lkdYD-3503020.geojson',
            'fill_color' => '#609B61',
        ]);

        SubDistrict::create([
            'code' => 3503030,
            'name' => 'KECAMATAN WATULIMO',
            'latitude' => -8.26538086,
            'longitude' => 111.71334564,
            'geojson_path' => 'public/geojson/lkdYD-3503030.geojson',
            'geojson_name' => 'lkdYD-3503030.geojson',
            'fill_color' => '#8D8BD5',
        ]);

        SubDistrict::create([
            'code' => 3503040,
            'name' => 'KECAMATAN KAMPAK',
            'latitude' => -8.20057564,
            'longitude' => 111.65381401,
            'geojson_path' => 'public/geojson/lkdYD-3503040.geojson',
            'geojson_name' => 'lkdYD-3503040.geojson',
            'fill_color' => '#4F968C',
        ]);

        SubDistrict::create([
            'code' => 3503050,
            'name' => 'KECAMATAN DONGKO',
            'latitude' => -8.20583663,
            'longitude' => 111.55995732,
            'geojson_path' => 'public/geojson/lkdYD-3503050.geojson',
            'geojson_name' => 'lkdYD-3503050.geojson',
            'fill_color' => '#D87571',
        ]);

        SubDistrict::create([
            'code' => 3503060,
            'name' => 'KECAMATAN PULE',
            'latitude' => -8.11192109,
            'longitude' => 111.53606286,
            'geojson_path' => 'public/geojson/lkdYD-3503060.geojson',
            'geojson_name' => 'lkdYD-3503060.geojson',
            'fill_color' => '#4F968C',
        ]);

        SubDistrict::create([
            'code' => 3503070,
            'name' => 'KECAMATAN KARANGAN',
            'latitude' => -8.07196342,
            'longitude' => 111.66759034,
            'geojson_path' => 'public/geojson/lkdYD-3503070.geojson',
            'geojson_name' => 'lkdYD-3503070.geojson',
            'fill_color' => '#FBBF24',
        ]);

        SubDistrict::create([
            'code' => 3503071,
            'name' => 'KECAMATAN SURUH',
            'latitude' => -8.11136189,
            'longitude' => 111.62447685,
            'geojson_path' => 'public/geojson/lkdYD-3503071.geojson',
            'geojson_name' => 'lkdYD-3503071.geojson',
            'fill_color' => '#FBBF24',
        ]);

        SubDistrict::create([
            'code' => 3503080,
            'name' => 'KECAMATAN GANDUSARI',
            'latitude' => -8.14151310,
            'longitude' => 111.71612139,
            'geojson_path' => 'public/geojson/lkdYD-3503080.geojson',
            'geojson_name' => 'lkdYD-3503080.geojson',
            'fill_color' => '#059669',
        ]);

        SubDistrict::create([
            'code' => 3503090,
            'name' => 'KECAMATAN DURENAN',
            'latitude' => -8.08806124,
            'longitude' => 111.80774481,
            'geojson_path' => 'public/geojson/lkdYD-3503090.geojson',
            'geojson_name' => 'lkdYD-3503090.geojson',
            'fill_color' => '#DB2777',
        ]);

        SubDistrict::create([
            'code' => 3503100,
            'name' => 'KECAMATAN POGALAN',
            'latitude' => -8.08886485,
            'longitude' => 111.74666186,
            'geojson_path' => 'public/geojson/lkdYD-3503100.geojson',
            'geojson_name' => 'lkdYD-3503100.geojson',
            'fill_color' => '#78716C',
        ]);

        SubDistrict::create([
            'code' => 3503110,
            'name' => 'KECAMATAN TRENGGALEK',
            'latitude' => -8.03392159,
            'longitude' => 111.71973751,
            'geojson_path' => 'public/geojson/lkdYD-3503110.geojson',
            'geojson_name' => 'lkdYD-3503110.geojson',
            'fill_color' => '#E09B6A',
        ]);

        SubDistrict::create([
            'code' => 3503120,
            'name' => 'KECAMATAN TUGU',
            'latitude' => -8.02866545,
            'longitude' => 111.62929611,
            'geojson_path' => 'public/geojson/lkdYD-3503120.geojson',
            'geojson_name' => 'lkdYD-3503120.geojson',
            'fill_color' => '#84CC16',
        ]);

        SubDistrict::create([
            'code' => 3503130,
            'name' => 'KECAMATAN BENDUNGAN',
            'latitude' => -7.95240074,
            'longitude' => 111.69897437,
            'geojson_path' => 'public/geojson/lkdYD-3503080.geojson',
            'geojson_name' => 'lkdYD-3503080.geojson',
            'fill_color' => '#4E9EC5',
        ]);
    }
}
