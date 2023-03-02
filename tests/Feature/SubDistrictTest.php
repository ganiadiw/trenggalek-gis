<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Http\UploadedFile;
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
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/sub-districts');
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kecamatan');
    }

    public function test_a_sub_district_create_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/sub-districts/create');
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kecamatan');
    }

    public function test_an_superadmin_can_create_new_sub_district_with_uploaded_geojson_file()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post('/dashboard/sub-districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson' => UploadedFile::fake()->create('3503010.geojson', 25, 'application/json'),
        ]);

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $response->assertRedirect('dashboard/sub-districts');
        $subDistrict = SubDistrict::where('code', 3503010)->first();
        $this->assertDatabaseHas('sub_districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'geojson_name' => $subDistrict->geojson_name,
        ]);
    }

    public function test_an_superadmin_can_create_new_sub_district_with_geojson_text()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post('dashboard/sub-districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_text_area' => json_encode($this->createGeoJson),
        ]);

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $this->assertJson(json_encode($this->createGeoJson));
        $response->assertRedirect('dashboard/sub-districts');
        $subDistrict = SubDistrict::where('code', 3503010)->first();
        $this->assertDatabaseHas('sub_districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $subDistrict->geojson_name,
        ]);
    }

    public function test_correct_data_must_be_provided_to_create_new_sub_district()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post('dashboard/sub-districts', [
            'code' => '',
            'name' => '',
            'latitude' => '',
            'longitude' => '',
            'fill_color' => '',
            'geojson' => '',
            'geojson_text_area' => '',
        ]);
        $response->assertInvalid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
    }

    public function test_an_superadmin_can_see_sub_district_show_page()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/' . $this->subDistrict->code);
        $response->assertStatus(200);
        $this->assertEquals('3503020', $this->subDistrict->code);
        $this->assertEquals('KECAMATAN MUNJUNGAN', $this->subDistrict->name);
        $this->assertEquals('-8.24312247', $this->subDistrict->latitude);
        $this->assertEquals('111.45431483', $this->subDistrict->longitude);
    }

    public function test_a_sub_district_edit_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/' . $this->subDistrict->code . '/edit');
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Kecamatan');
    }

    public function test_an_superadmin_can_update_sub_district_with_uploaded_geojson_file()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);

        $response = $this->actingAs($this->superAdmin)->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => 3503030,
            'name' => 'KECAMATAN WATULIMO',
            'latitude' => -8.26538086,
            'longitude' => 111.71334564,
            'fill_color' => '#059669',
            'geojson' => UploadedFile::fake()->create('3503020.geojson', 25, 'application/json'),
        ]);
        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $response->assertRedirect('dashboard/sub-districts');
        $subDistrict = SubDistrict::where('code', 3503030)->first();
        $this->assertDatabaseHas('sub_districts', [
            'code' => 3503030,
            'name' => 'KECAMATAN WATULIMO',
            'latitude' => -8.26538086,
            'longitude' => 111.71334564,
            'fill_color' => '#059669',
            'geojson_name' => $subDistrict->geojson_name,
        ]);
        $this->assertDatabaseMissing('sub_districts', [
            'code' => 3503020,
        ]);
    }

    public function test_an_superadmin_can_update_sub_district_with_uploaded_geojson_text()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);

        $response = $this->actingAs($this->superAdmin)->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => 3503030,
            'name' => 'KECAMATAN WATULIMO',
            'latitude' => -8.26538086,
            'longitude' => 111.71334564,
            'fill_color' => '#059669',
            'geojson_text_area' => json_encode($this->updateGeoJson),
        ]);
        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $this->assertJson(json_encode($this->updateGeoJson));
        $response->assertRedirect('dashboard/sub-districts/');
        $subDistrict = SubDistrict::where('code', 3503030)->first();
        $this->assertDatabaseHas('sub_districts', [
            'code' => 3503030,
            'name' => 'KECAMATAN WATULIMO',
            'latitude' => -8.26538086,
            'longitude' => 111.71334564,
            'fill_color' => '#059669',
            'geojson_name' => $subDistrict->geojson_name,
        ]);
        $this->assertDatabaseMissing('sub_districts', [
            'code' => 3503020,
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => -8.3030696,
            'longitude' => 111.5768607,
            'fill_color' => '#059669',
        ]);
    }

    public function test_correct_data_must_be_provided_to_update_sub_district()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => '',
            'name' => '',
            'latitude' => '',
            'longitude' => '',
            'fill_color' => '',
        ]);
        $response->assertInvalid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
    }

    public function test_an_superadmin_can_delete_sub_district()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->delete('dashboard/sub-districts/' . $this->subDistrict->code);
        $this->assertModelMissing($this->subDistrict);
        $response->assertRedirect('dashboard/sub-districts');
    }

    public function test_an_webgis_administrator_cannot_create_new_sub_district()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->post('dashboard/sub-districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_text_area' => json_encode($this->createGeoJson),
        ]);
        $response->assertForbidden();
    }

    public function test_an_webgis_administrator_cannot_update_sub_district()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);

        $response = $this->actingAs($this->webgisAdmin)->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => 3503020,
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => -8.3030696,
            'longitude' => 111.5768607,
            'fill_color' => '#059669',
            'geojson' => UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json'),
        ]);
        $response->assertForbidden();
    }

    public function test_an_webgis_administrator_cannot_delete_sub_district()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->delete('dashboard/sub-districts/' . $this->subDistrict->code);
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_create_new_sub_district()
    {
        $response = $this->post('dashboard/sub-districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson' => UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json'),
        ]);
        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_an_guest_cannot_update_sub_district()
    {
        $response = $this->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => 3503020,
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => -8.3030696,
            'longitude' => 111.5768607,
            'fill_color' => '#059669',
            'geojson' => UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json'),
        ]);
        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_an_guest_cannot_delete_sub_district()
    {
        $response = $this->delete('dashboard/sub-districts/' . $this->subDistrict->code);
        $this->assertGuest();
        $response->assertRedirect();
    }

    public function test_an_superadmin_can_search_contains_sub_district_data()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/search', [
            'search' => $this->subDistrict->name,
        ]);
        $response->assertSeeText($this->subDistrict->name);
    }
}
