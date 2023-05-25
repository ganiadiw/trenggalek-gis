<?php

namespace Tests\Feature\SubDistrict;

use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateSubDistrictTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

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

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $this->assertJson(json_encode($this->createGeoJson));
    }

    public function test_sub_district_create_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/sub-districts/create');

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kecamatan');
    }

    public function test_sub_district_create_input_validation()
    {
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

    public function test_super_admin_can_create_sub_district_with_upload_geojson_file()
    {
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
        $response->assertSessionHasNoErrors();

        $subDistrict = SubDistrict::where('code', 3503010)->first();

        $this->assertTrue(Storage::exists('public/geojson/' . $subDistrict->geojson_name));
        $this->assertDatabaseHas('sub_districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'fill_color' => '#0ea5e9',
            'geojson_name' => $subDistrict->geojson_name,
        ]);
    }

    public function test_super_admin_can_create_sub_district_with_geojson_text()
    {
        $response = $this->actingAs($this->superAdmin)->post('dashboard/sub-districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_text_area' => json_encode($this->createGeoJson),
        ]);

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $response->assertRedirect('dashboard/sub-districts');
        $response->assertSessionHasNoErrors();

        $subDistrict = SubDistrict::where('code', 3503010)->first();

        $this->assertTrue(Storage::exists('public/geojson/' . $subDistrict->geojson_name));
        $this->assertDatabaseHas('sub_districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson_name' => $subDistrict->geojson_name,
        ]);
    }

    public function test_webgis_admin_cannot_create_sub_district()
    {
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

    public function test_guest_cannot_create_sub_district()
    {
        $response = $this->post('dashboard/sub-districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson' => UploadedFile::fake()->create('gt47g-3503020.geojson', 25, 'application/json'),
        ]);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
