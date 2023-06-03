<?php

namespace Tests\Feature\SubDistrict;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class DeleteSubDistrictTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

    private SubDistrict $subDistrict;

    const MAIN_URL = '/dashboard/sub-districts/';

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

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_super_admin_can_delete_sub_district()
    {
        $response = $this->actingAs($this->superAdmin)->delete(self::MAIN_URL . $this->subDistrict->code);

        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertFalse(Storage::exists(self::GEOJSON_PATH . $this->subDistrict->geojson_name));
        $this->assertDatabaseMissing('sub_districts', [
            'code' => 3503020,
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => -8.24312247,
            'longitude' => 111.45431483,
            'fill_color' => '#16a34a',
        ]);
    }

    public function test_delete_data_redirect_to_related_data_for_sub_district_with_relationship_to_tourist_destinations()
    {
        Category::factory()->create();
        TouristDestination::factory()->create();

        $response = $this->actingAs($this->superAdmin)->delete(self::MAIN_URL . $this->subDistrict->code);

        $response->assertRedirect(self::MAIN_URL . $this->subDistrict->code . '/related-tourist-destination');
        $response->assertSessionHasNoErrors();
    }

    public function test_webgis_admin_cannot_delete_sub_district()
    {
        $response = $this->actingAs($this->webgisAdmin)->delete(self::MAIN_URL . $this->subDistrict->code);

        $response->assertForbidden();
    }

    public function test_guest_cannot_delete_sub_district()
    {
        $response = $this->delete(self::MAIN_URL . $this->subDistrict->code);

        $response->assertRedirect();

        $this->assertGuest();
    }
}
