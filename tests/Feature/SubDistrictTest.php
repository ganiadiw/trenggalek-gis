<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubDistrictTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

    private SubDistrict $subDistrict;

    private $createGeoJson = [
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
        ],
    ];

    private $updateGeoJson = [
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
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'address' => 'Desa Panggul, Kecamatan Panggul',
            'phone_number' => '081234567890',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'is_admin' => 0,
        ]);
        $this->subDistrict = SubDistrict::factory()->create();
    }

    public function test_an_superadmin_can_see_sub_district_management_page()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.sub-districts.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kecamatan');
    }

    public function test_a_sub_district_create_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.sub-districts.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kecamatan');
    }

    public function test_an_superadmin_can_create_new_sub_district_with_uploaded_geojson_file()
    {
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503010.geojson', 25, 'application/json');
        $data = [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
        ];

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post(route('dashboard.sub-districts.store', $data));
        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
        $response->assertRedirect();
    }

    public function test_an_superadmin_can_create_new_sub_district_with_geojson_text()
    {
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503010.geojson', 25, 'application/json');

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post(route('dashboard.sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode($this->createGeoJson),
        ]));

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
        $this->assertJson(json_encode($this->createGeoJson));
        $response->assertRedirect(route('dashboard.sub-districts.index'));
    }

    public function test_correct_data_must_be_provided_to_create_new_sub_district()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post(route('dashboard.sub-districts.store', [
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
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.sub-districts.show', ['sub_district' => $this->subDistrict]));
        $response->assertStatus(200);
        $this->assertEquals('3503020', $this->subDistrict->code);
        $this->assertEquals('MUNJUNGAN', $this->subDistrict->name);
        $this->assertEquals('-8.3030696', $this->subDistrict->latitude);
        $this->assertEquals('111.5768607', $this->subDistrict->longitude);
    }

    public function test_a_sub_district_edit_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.sub-districts.edit', ['sub_district' => $this->subDistrict]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Kecamatan');
    }

    public function test_an_superadmin_can_update_sub_district_with_uploaded_geojson_file()
    {
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $this->assertEquals(1, $this->superAdmin->is_admin);

        $response = $this->actingAs($this->superAdmin)->put(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
        ]);
        $response->assertValid();
        $response->assertRedirect(route('dashboard.sub-districts.index'));
    }

    public function test_an_superadmin_can_update_sub_district_with_uploaded_geojson_text()
    {
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $this->assertEquals(1, $this->superAdmin->is_admin);

        $response = $this->actingAs($this->superAdmin)->put(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode($this->updateGeoJson),
        ]);
        $response->assertValid();
        $this->assertJson(json_encode($this->updateGeoJson));
        $response->assertRedirect(route('dashboard.sub-districts.index'));
    }

    public function test_correct_data_must_be_provided_to_update_sub_district()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]), [
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
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->delete(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]));
        $this->assertModelMissing($this->subDistrict);
        $response->assertRedirect(route('dashboard.sub-districts.index'));
    }

    public function test_an_webgis_administrator_cannot_create_new_sub_district()
    {
        $gojsonFile = UploadedFile::fake()->create('gt47g-3503010.geojson', 25, 'application/json');

        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->post(route('dashboard.sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode($this->createGeoJson),
        ]));
        $response->assertForbidden();
    }

    public function test_an_webgis_administrator_cannot_update_sub_district()
    {
        Storage::fake('geojson');

        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $this->assertEquals(0, $this->webgisAdmin->is_admin);

        $response = $this->actingAs($this->webgisAdmin)->put(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode($this->updateGeoJson),
        ]);
        $response->assertForbidden();
    }

    public function test_an_webgis_administrator_cannot_delete_sub_district()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->delete(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]));
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_create_new_sub_district()
    {
        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $response = $this->post(route('dashboard.sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode($this->createGeoJson),
        ]));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_an_guest_cannot_update_sub_district()
    {
        $gojsonFile = UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json');

        $response = $this->put(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669',
            'geojson_name' => $gojsonFile->name,
            'geojson_path' => $gojsonFile->path(),
            'geojson_text_area' => json_encode($this->updateGeoJson),
        ]);
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_an_guest_cannot_delete_sub_district()
    {
        $response = $this->delete(route('dashboard.sub-districts.update', ['sub_district' => $this->subDistrict]));
        $this->assertGuest();
        $response->assertRedirect();
    }

    public function test_an_superadmin_can_search_contains_sub_district_data()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.sub-districts.search'), [
            'search' => $this->subDistrict->name,
        ]);
        $response->assertSeeText($this->subDistrict->name);
    }
}
