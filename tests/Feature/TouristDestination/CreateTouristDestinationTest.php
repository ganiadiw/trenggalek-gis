<?php

namespace Tests\Feature\TouristDestination;

use App\Models\SubDistrict;
use App\Models\TouristDestinationCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTouristDestinationTest extends TestCase
{
    private User $user;

    private TouristDestinationCategory $touristDestinationCategory;

    private SubDistrict $subDistrict;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::disk('local')->put('public/cover-images/' . $image, '');

        $this->user = User::factory()->create();
        $this->touristDestinationCategory = TouristDestinationCategory::factory()->create();
        $this->subDistrict = SubDistrict::factory()->create();
    }

    public function test_a_tourist_destination_create_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/create');
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_create_new_tourist_destination()
    {
        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destinations', [
            'name' => '',
        ]);
        $response->assertInvalid();
    }

    public function test_an_authenticated_user_can_create_new_tourist_destination()
    {
        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destinations', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'tourist_destination_category_id' => $this->touristDestinationCategory->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png'),
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);
        $response->assertValid();
        $response->assertRedirect('/dashboard/tourist-destinations');
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Pelang',
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
        ]);
    }

    public function test_an_guest_cannot_create_new_tourist_destination()
    {
        $response = $this->post('dashboard/tourist-destinations', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'tourist_destination_category_id' => $this->touristDestinationCategory->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png'),
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);
        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
