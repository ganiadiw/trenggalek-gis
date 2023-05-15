<?php

namespace Tests\Feature\SubDistrict;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;

class SubDistrictTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private SubDistrict $subDistrict;

    protected function setUp(): void
    {
        parent::setUp();

        $geojsonFile = UploadedFile::fake()->create('3503020.geojson', 25, 'application/json');
        $geojsonName = Str::random(5) . '-' . $geojsonFile;

        $this->superAdmin = User::factory()->create();
        $this->subDistrict = SubDistrict::factory()->create([
            'geojson_name' => $geojsonName,
            'geojson_path' => 'public/geojson/' . $geojsonName,
        ]);
    }

    public function test_an_superadmin_can_see_sub_district_management_page()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/sub-districts');
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kecamatan');
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

    public function test_related_tourist_destination_data_is_displayed()
    {
        Category::factory()->create();
        TouristDestination::factory()->create();

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/' . $this->subDistrict->code . '/related-tourist-destination');
        $response->assertStatus(200);
        $response->assertSeeText('Data Destinasi Wisata yang Berada di ' . $this->subDistrict->name);
        $response->assertSeeText(['Pantai Konang', 'LDMH', 'Desa Nglebeng, Kecamatan Panggul']);
    }

    public function test_related_tourist_destination_data_can_be_searched()
    {
        Category::factory()->create();
        TouristDestination::factory()->create();

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)
                    ->get('dashboard/sub-districts/' . $this->subDistrict->code . '/related-tourist-destination/search?column_name=name&search_value=konang');
        $response->assertStatus(200);
        $response->assertSeeText('Data Destinasi Wisata yang Berada di ' . $this->subDistrict->name);
        $response->assertSeeText(['Pantai Konang', 'LDMH', 'Desa Nglebeng, Kecamatan Panggul']);
    }

    public function test_sub_district_geojson_file_can_be_downloaded()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->actingAs($this->superAdmin)->post('/dashboard/sub-districts', [
            'code' => 3503010,
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9',
            'geojson' => UploadedFile::fake()->create('3503010.geojson', 25, 'application/json'),
        ]);
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/3503010/download');
        $response->assertStatus(200);
    }

    public function test_an_superadmin_can_search_contains_sub_district_data()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/search?column_name=name&search_value=munjungan');
        $response->assertSeeText($this->subDistrict->name);
    }
}
