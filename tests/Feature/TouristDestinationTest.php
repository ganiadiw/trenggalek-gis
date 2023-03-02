<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\TouristDestinationCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TouristDestinationTest extends TestCase
{
    private User $user;

    private TouristDestinationCategory $touristDestinationCategory;

    private SubDistrict $subDistrict;

    private TouristDestination $touristDestination;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->touristDestinationCategory = TouristDestinationCategory::factory()->create();
        $this->subDistrict = SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create();
    }

    public function test_an_authenticated_user_can_see_tourist_destination_management_page()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations');
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Destinasi Wisata');
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
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png', 2000),
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
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_see_tourist_destinations_show_page()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/' . $this->touristDestination->slug);
        $response->assertRedirect('/tourist-destinations/' . $this->touristDestination->slug);
    }

    public function test_a_tourist_destination_edit_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/' . $this->touristDestination->slug . '/edit');
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Destinasi Wisata');
        $this->assertEquals('Pantai Konang', $this->touristDestination->name);
    }

    public function test_correct_data_must_be_provided_to_update_tourist_destination()
    {
        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'name' => '',
        ]);
        $response->assertInvalid();
        $response->assertSessionHasErrors();
        $response->assertRedirect(url()->previous());
    }

    public function test_an_authenticated_user_can_update_tourist_destination()
    {
        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'tourist_destination_category_id' => $this->touristDestinationCategory->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/dashboard/tourist-destinations');
    }

    public function test_an_authenticated_user_can_delete_tourist_destination()
    {
        $response = $this->actingAs($this->user)->delete('/dashboard/tourist-destinations/' . $this->touristDestination->slug);
        $response->assertRedirect('/dashboard/tourist-destinations');
    }
}
