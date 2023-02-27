<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\TouristDestinationCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $response = $this->actingAs($this->user)->get(route('dashboard.tourist-destinations.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Destinasi Wisata');
    }

    public function test_a_tourist_destination_create_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.tourist-destinations.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_create_new_tourist_destination()
    {
        $response = $this->actingAs($this->user)->post(route('dashboard.tourist-destinations.store', [
            'name' => '',
        ]));
        $response->assertInvalid();
    }

    public function test_an_authenticated_user_can_create_new_tourist_destination()
    {
        // Storage::fake('tourist-destinations');
        // dd(UploadedFile::fake()->image('image-cover.jpg'));

        $response = $this->actingAs($this->user)->post(route('dashboard.tourist-destinations.store', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'tourist_destination_category_id' => $this->touristDestinationCategory->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => asset('assets/images/trenggalek.png'),
            'latitude' => '-8.257023266748266, 111.42379872584968',
            'longitude' => '111.42379872584968',
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]));
        $response->assertValid();
        $response->assertRedirect(route('dashboard.tourist-destinations.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Pelang',
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
        ]);
    }

    public function test_an_guest_cannot_create_new_tourist_destination()
    {
        $response = $this->post(route('dashboard.tourist-destinations.store', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'tourist_destination_category_id' => $this->touristDestinationCategory->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'latitude' => '-8.257023266748266',
            'longitude' => '111.42379872584968',
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_see_tourist_destinations_show_page()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.tourist-destinations.show', ['tourist_destination' => $this->touristDestination]));
        $response->assertRedirect(route('guest.tourist-destinations.show', ['tourist_destination' => $this->touristDestination]));
    }

    public function test_a_tourist_destination_edit_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.tourist-destinations.edit', ['tourist_destination' => $this->touristDestination]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Destinasi Wisata');
        $this->assertEquals('Pantai Konang', $this->touristDestination->name);
    }

    public function test_correct_data_must_be_provided_to_update_tourist_destination()
    {
        $response = $this->actingAs($this->user)->put(route('dashboard.tourist-destinations.update', ['tourist_destination' => $this->touristDestination]), [
            'name' => '',
        ]);
        $response->assertInvalid();
        $response->assertSessionHasErrors();
        $response->assertRedirect(url()->previous());
    }

    public function test_an_authenticated_user_can_update_tourist_destination()
    {
        $response = $this->actingAs($this->user)->put(route('dashboard.tourist-destinations.update', ['tourist_destination' => $this->touristDestination]), [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'tourist_destination_category_id' => $this->touristDestinationCategory->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'latitude' => '-8.257023266748266, 111.42379872584968',
            'longitude' => '111.42379872584968',
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dashboard.tourist-destinations.index'));
    }

    public function test_an_authenticated_user_can_delete_tourist_destination()
    {
        $response = $this->actingAs($this->user)->delete(route('dashboard.tourist-destinations.destroy', ['tourist_destination' => $this->touristDestination]));
        $response->assertRedirect(route('dashboard.tourist-destinations.index'));
    }
}
