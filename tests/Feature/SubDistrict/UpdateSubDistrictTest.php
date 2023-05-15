<?php

namespace Tests\Feature\SubDistrict;

use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateSubDistrictTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

    private SubDistrict $subDistrict;

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

        $geojsonFile = UploadedFile::fake()->create('3503020.geojson', 25, 'application/json');
        $geojsonName = Str::random(5) . '-' . $geojsonFile;

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
        $this->subDistrict = SubDistrict::factory()->create([
            'geojson_name' => $geojsonName,
            'geojson_path' => 'public/geojson/' . $geojsonName,
        ]);

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $this->assertJson(json_encode($this->updateGeoJson));
    }

    public function test_a_sub_district_edit_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/' . $this->subDistrict->code . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Kecamatan');
        $response->assertSessionHasNoErrors();
    }

    public function test_an_superadmin_can_update_sub_district_with_upload_geojson_file()
    {
        $response = $this->actingAs($this->superAdmin)->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => 3503030,
            'name' => 'KECAMATAN WATULIMO',
            'latitude' => -8.26538086,
            'longitude' => 111.71334564,
            'fill_color' => '#059669',
            'geojson' => UploadedFile::fake()->create('3503020.geojson', 25, 'application/json'),
        ]);

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $response->assertRedirect('dashboard/sub-districts/3503030/edit');
        $response->assertSessionHasNoErrors();

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
            'latitude' => -8.24312247,
            'longitude' => 111.45431483,
            'fill_color' => '#16a34a',
            'geojson_name' => $this->subDistrict->geojson_name,
        ]);
        $this->assertTrue(Storage::exists('public/geojson/' . $subDistrict->geojson_name));
        $this->assertFalse(Storage::exists('public/geojson/' . $this->subDistrict->geojson_name));
    }

    public function test_an_superadmin_can_update_sub_district_with_geojson_text()
    {
        $response = $this->actingAs($this->superAdmin)->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => 3503030,
            'name' => 'KECAMATAN WATULIMO',
            'latitude' => -8.26538086,
            'longitude' => 111.71334564,
            'fill_color' => '#059669',
            'geojson_text_area' => json_encode($this->updateGeoJson),
        ]);

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $response->assertRedirect('dashboard/sub-districts/3503030/edit');
        $response->assertSessionHasNoErrors();

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
            'geojson_name' => $this->subDistrict->geojson_name,
        ]);
        $this->assertTrue(Storage::exists('public/geojson/' . $subDistrict->geojson_name));
        $this->assertFalse(Storage::exists('public/geojson/' . $this->subDistrict->geojson_name));
    }

    public function test_correct_data_must_be_provided_to_update_sub_district()
    {
        $response = $this->actingAs($this->superAdmin)->put('dashboard/sub-districts/' . $this->subDistrict->code, [
            'code' => '',
            'name' => '',
            'latitude' => '',
            'longitude' => '',
            'fill_color' => '',
        ]);

        $response->assertInvalid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
    }

    public function test_an_webgis_administrator_cannot_update_sub_district()
    {
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

        $response->assertRedirect('/login');
        
        $this->assertGuest();
    }
}
