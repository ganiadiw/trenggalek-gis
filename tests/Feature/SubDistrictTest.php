<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubDistrictTest extends TestCase
{
    public static $createGeoJson = [
        'type' => 'FeatureCollection',
        'features' => [
            'type' => 'Feature',
            'properties' => [
                'name' => 'KECAMATAN PANGGUL',
            ],
            'geometry' => [
                [
                    [
                        111.45021038517558,
                        -8.243895803050165,
                    ],
                    [
                        111.43831334905423,
                        -8.24928391384077,
                    ],
                    [
                        111.45175632772282,
                        -8.253308319040656,
                    ],
                    [
                        111.45021038517558,
                        -8.243895803050165,
                    ],
                ],
            ],
            'type' => 'Polygon',
        ],
    ];

    public static $updateGeoJson = [
        'type' => 'FeatureCollection',
        'features' => [
            'type' => 'Feature',
            'properties' => [
                'name' => 'KECAMATAN MUNJUNGAN',
            ],
            'geometry' => [
                [
                    [
                        111.45942887011313,
                        -8.237330319885928,
                    ],
                    [
                        111.44650869322885,
                        -8.254595843964069,
                    ],
                    [
                        111.46789633067027,
                        -8.26203640203876,
                    ],
                    [
                        111.46935623766348,
                        -8.245927055829426,
                    ],
                    [
                        111.45942887011313,
                        -8.237330319885928,
                    ],
                ],
            ],
            'type' => 'Polygon',
        ],
    ];

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
            'geojson_text_area' => json_encode(self::$createGeoJson),
        ]));

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
        $this->assertJson(json_encode(self::$createGeoJson));
        $response->assertRedirect(route('sub-districts.index'));
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

    public function test_an_superadmin_can_see_sub_district_show_page()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('sub-districts.show', ['sub_district' => $subDistrict]));
        $response->assertStatus(200);
        $this->assertEquals('3503020', $subDistrict->code);
        $this->assertEquals('MUNJUNGAN', $subDistrict->name);
        $this->assertEquals('-8.3030696', $subDistrict->latitude);
        $this->assertEquals('111.5768607', $subDistrict->longitude);
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
        $response->assertRedirect(route('sub-districts.index'));
    }

    public function test_an_superadmin_can_update_sub_district_with_uploaded_geojson_text()
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
            'geojson_text_area' => json_encode(self::$updateGeoJson),
        ]);
        $response->assertValid();
        $this->assertJson(json_encode(self::$updateGeoJson));
        $response->assertRedirect(route('sub-districts.index'));
    }

    public function test_correct_data_must_be_provided_to_update_sub_district()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->put(route('sub-districts.update', ['sub_district' => $subDistrict]), [
            'code' => '',
            'name' => '',
            'latitude' => '',
            'longitude' => '',
            'fill_color' => '',
            'geojson_name' => '',
            'geojson_path' => '',
            'geojson_text_area' => '',
        ]);
        $response->assertInvalid();
    }

    public function test_an_superadmin_can_delete_sub_district()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->delete(route('sub-districts.update', ['sub_district' => $subDistrict]));
        $response->assertRedirect(route('sub-districts.index'));
    }

    public function test_an_superadmin_cannot_create_new_sub_district()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $gojsonFile = UploadedFile::fake()->create('gt47g-3503010.geojson', 25, 'application/json');

        $this->assertEquals(0, $user->is_admin);
        $response = $this->actingAs($user)->post(route('sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode(self::$createGeoJson),
        ]));
        $response->assertForbidden();
    }

    public function test_an_superadmin_cannot_update_sub_district()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $subDistrict = SubDistrict::factory()->create();
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $this->assertEquals(0, $user->is_admin);

        $response = $this->actingAs($user)->put(route('sub-districts.update', ['sub_district' => $subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode(self::$updateGeoJson),
        ]);
        $response->assertForbidden();
    }

    public function test_an_superadmin_cannot_delete_sub_district()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $subDistrict = SubDistrict::factory()->create();

        $this->assertEquals(0, $user->is_admin);
        $response = $this->actingAs($user)->delete(route('sub-districts.update', ['sub_district' => $subDistrict]));
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_create_new_sub_district()
    {
        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $response = $this->post(route('sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode(self::$createGeoJson),
        ]));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_an_guest_cannot_update_sub_district()
    {
        $subDistrict = SubDistrict::factory()->create();
        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $response = $this->put(route('sub-districts.update', ['sub_district' => $subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode(self::$updateGeoJson),
        ]);
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_an_guest_cannot_delete_sub_district()
    {
        $subDistrict = SubDistrict::factory()->create();

        $response = $this->delete(route('sub-districts.update', ['sub_district' => $subDistrict]));
        $this->assertGuest();
        $response->assertRedirect();
    }
}
