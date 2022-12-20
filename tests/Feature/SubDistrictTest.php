<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubDistrictTest extends TestCase
{
    public function test_an_superadmin_can_see_sub_district_management_page()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('sub-districts.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kecamatan');
    }

    public function test_a_create_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('sub-districts.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kecamatan');
    }

    public function test_an_superadmin_can_create_new_sub_district_with_uploaded_geojson_file()
    {
        $user = User::factory()->create();
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503010.geojson', 25, 'application/json');

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->post(route('sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
        ]));
        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
        $response->assertRedirect();
    }

    public function test_an_superadmin_can_create_new_sub_district_with_geojson_text()
    {
        $user = User::factory()->create();
        Storage::fake('geojson');
        $geojsonText = json_encode([
            "type" => "FeatureCollection",
            "features" => [
                "type" => "Feature",
                "properties" => [
                    "name" => "KECAMATAN PANGGUL"
                ],
                "geometry" => [
                    [
                        [
                          111.45021038517558,
                          -8.243895803050165
                        ],
                        [
                          111.43831334905423,
                          -8.24928391384077
                        ],
                        [
                          111.45175632772282,
                          -8.253308319040656
                        ],
                        [
                          111.45021038517558,
                          -8.243895803050165
                        ]
                    ]
                ],
                "type" => "Polygon"
            ]
        ]);

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503010.geojson', 25, 'application/json');

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->post(route('sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => $geojsonText,
        ]));

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
        $this->assertJson($geojsonText);
        $response->assertRedirect();
    }

    public function test_correct_data_must_be_provided_to_create_new_sub_district()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->post(route('sub-districts.store', [
            'code' => '',
            'name' => '',
            'latitude' => '',
            'longitude' => '',
            'fill_color' => '',
            'geojson_name' => '',
            'geojson_path' => '',
            'geojson_text_area' => '',
        ]));
        $response->assertInvalid();
    }

    public function test_a_edit_page_can_be_rendered()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('sub-districts.edit', ['sub_district' => $subDistrict]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Kecamatan');
    }

    public function test_an_superadmin_can_update_sub_district_with_uploaded_geojson_file()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $this->assertEquals(1, $user->is_admin);

        $response = $this->actingAs($user)->put(route('sub-districts.update', ['sub_district' => $subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
        ]);
        $response->assertValid();
        $response->assertRedirect();
    }

    public function test_an_superadmin_can_update_sub_district_with_uploaded_geojson_text()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();
        Storage::fake('geojson');
        $geojsonText = json_encode([
            "type" => "FeatureCollection",
            "features" => [
                "type" => "Feature",
                "properties" => [
                    "name" => "KECAMATAN MUNJUNGAN"
                ],
                "geometry" => [
                    [
                        [
                          111.45021038517558,
                          -8.243895803050165
                        ],
                        [
                          111.43831334905423,
                          -8.24928391384077
                        ],
                        [
                          111.45175632772282,
                          -8.253308319040656
                        ],
                        [
                          111.45021038517558,
                          -8.243895803050165
                        ]
                    ]
                ],
                "type" => "Polygon"
            ]
        ]);

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $this->assertEquals(1, $user->is_admin);

        $response = $this->actingAs($user)->put(route('sub-districts.update', ['sub_district' => $subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => $geojsonText,
        ]);
        $response->assertValid();
        $this->assertJson($geojsonText);
        $response->assertRedirect();
    }
}
