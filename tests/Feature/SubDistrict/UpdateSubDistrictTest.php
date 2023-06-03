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

    const UPDATE_GEOJSON = [
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

    const MAIN_URL = '/dashboard/sub-districts/';

    private $data = [
        'code' => 3503030,
        'name' => 'KECAMATAN WATULIMO',
        'latitude' => -8.26538086,
        'longitude' => 111.71334564,
        'fill_color' => '#059669',
    ];

    private $data2;

    private $oldData;

    private $updatedSubDistrict;

    const GEOJSON_PATH = 'geojson/';

    protected function setUp(): void
    {
        parent::setUp();

        $geojsonFile = UploadedFile::fake()->create('3503020.geojson', 25, 'application/json');
        $geojsonName = Str::random(5) . '-' . $geojsonFile;

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@gmail.com',
            'is_admin' => 0,
        ]);
        $this->subDistrict = SubDistrict::factory()->create([
            'geojson_name' => $geojsonName,
            'geojson_path' => self::GEOJSON_PATH . $geojsonName,
        ]);
        $this->data2 = array_merge($this->data, [
            'geojson_text_area' => json_encode(self::UPDATE_GEOJSON),
        ]);
        $this->oldData = [
            'code' => $this->subDistrict->code,
            'name' => $this->subDistrict->name,
            'latitude' => $this->subDistrict->latitude,
            'longitude' => $this->subDistrict->longitude,
            'fill_color' => $this->subDistrict->fill_color,
            'geojson_name' => $this->subDistrict->geojson_name,
        ];

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $this->assertJson(json_encode(self::UPDATE_GEOJSON));
    }

    public function test_sub_district_edit_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . $this->subDistrict->code . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Kecamatan');
        $response->assertSessionHasNoErrors();
    }

    public function test_sub_district_update_input_validation()
    {
        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->subDistrict->code, ['']);

        $response->assertInvalid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
    }

    public function test_super_admin_can_update_sub_district_with_upload_geojson_file()
    {
        $dataWithGeojsonFile = array_merge($this->data, ['geojson' => UploadedFile::fake()->create('3503030.geojson', 25, 'application/json')]);

        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->subDistrict->code, $dataWithGeojsonFile);

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $response->assertRedirect(self::MAIN_URL . '3503030/edit');
        $response->assertSessionHasNoErrors();

        $this->updatedSubDistrict = SubDistrict::where('code', 3503030)->first();

        $this->assertTrue(Storage::exists(self::GEOJSON_PATH . $this->updatedSubDistrict->geojson_name));
        $this->assertFalse(Storage::exists(self::GEOJSON_PATH . $this->subDistrict->geojson_name));
        $this->assertDatabaseHas('sub_districts', array_merge($this->data, ['geojson_name' => $this->updatedSubDistrict->geojson_name]));
        $this->assertDatabaseMissing('sub_districts', $this->oldData);
    }

    public function test_super_admin_can_update_sub_district_with_geojson_text()
    {
        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->subDistrict->code, $this->data2);

        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color', 'geojson', 'geojson_text_area']);
        $response->assertRedirect(self::MAIN_URL . '3503030/edit');
        $response->assertSessionHasNoErrors();

        $this->updatedSubDistrict = SubDistrict::where('code', 3503030)->first();

        $this->assertDatabaseHas('sub_districts', array_merge($this->data, ['geojson_name' => $this->updatedSubDistrict->geojson_name]));
        $this->assertDatabaseMissing('sub_districts', $this->oldData);
        $this->assertTrue(Storage::exists(self::GEOJSON_PATH . $this->updatedSubDistrict->geojson_name));
        $this->assertFalse(Storage::exists(self::GEOJSON_PATH . $this->subDistrict->geojson_name));
    }

    public function test_webgis_admin_cannot_update_sub_district()
    {
        $response = $this->actingAs($this->webgisAdmin)->put(self::MAIN_URL . $this->subDistrict->code, $this->data2);

        $response->assertForbidden();
    }

    public function test_guest_cannot_update_sub_district()
    {
        $response = $this->put(self::MAIN_URL . $this->subDistrict->code, $this->data2);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
