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

    private User $webgisAdmin;

    private SubDistrict $subDistrict;

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
    }

    public function test_super_admin_can_visit_the_sub_district_management_page()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/sub-districts');

        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kecamatan');
        $response->assertSessionHasNoErrors();
    }

    public function test_webgis_admin_cannot_visit_the_sub_district_management_page()
    {
        $response = $this->actingAs($this->webgisAdmin)->get('/dashboard/sub-districts');

        $response->assertForbidden();
    }

    public function test_guest_cannot_visit_the_sub_district_management_page()
    {
        $response = $this->get('/dashboard/sub-districts');

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_super_admin_can_search_contains_sub_district_data()
    {
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/search?column_name=name&search_value=munjungan');

        $response->assertSeeText($this->subDistrict->name);
        $response->assertSessionHasNoErrors();
    }

    public function test_notification_is_displayed_for_search_not_found_sub_district_data()
    {
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/search?column_name=name&search_value=12wd3');

        $response->assertSeeText('Data tidak tersedia');
        $response->assertSessionHasNoErrors();
    }

    public function test_the_sub_district_show_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/' . $this->subDistrict->code);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();

        $this->assertEquals('3503020', $this->subDistrict->code);
        $this->assertEquals('KECAMATAN MUNJUNGAN', $this->subDistrict->name);
        $this->assertEquals('-8.24312247', $this->subDistrict->latitude);
        $this->assertEquals('111.45431483', $this->subDistrict->longitude);
    }

    public function test_related_tourist_destination_data_is_displayed()
    {
        Category::factory()->create();
        TouristDestination::factory()->create();

        $response = $this->actingAs($this->superAdmin)->get('dashboard/sub-districts/' . $this->subDistrict->code . '/related-tourist-destination');

        $response->assertStatus(200);
        $response->assertSeeText('Data Destinasi Wisata yang Berada di ' . $this->subDistrict->name);
        $response->assertSeeText(['Pantai Konang', 'LDMH', 'Desa Nglebeng, Kecamatan Panggul']);
        $response->assertSessionHasNoErrors();
    }

    public function test_super_admin_can_search_contains_related_tourist_destination_data()
    {
        Category::factory()->create();
        TouristDestination::factory()->create();

        $response = $this->actingAs($this->superAdmin)
                    ->get('dashboard/sub-districts/' . $this->subDistrict->code . '/related-tourist-destination/search?column_name=name&search_value=konang');

        $response->assertStatus(200);
        $response->assertSeeText('Data Destinasi Wisata yang Berada di ' . $this->subDistrict->name);
        $response->assertSeeText(['Pantai Konang', 'LDMH', 'Desa Nglebeng, Kecamatan Panggul']);
        $response->assertSessionHasNoErrors();
    }

    public function test_sub_district_geojson_file_can_be_downloaded()
    {
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
        $response->assertSessionHasNoErrors();
    }
}
