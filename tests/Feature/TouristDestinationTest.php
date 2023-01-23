<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\TouristDestinationCategory;
use App\Models\User;
use Tests\TestCase;

class TouristDestinationTest extends TestCase
{
    private User $user;

    private TouristDestinationCategory $touristDestinationCategory;

    private SubDistrict $subDistrict;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->touristDestinationCategory = TouristDestinationCategory::factory()->create();
        $this->subDistrict = SubDistrict::factory()->create();
    }

    public function test_an_authenticated_user_can_see_tourist_destination_management_page()
    {
        $response = $this->actingAs($this->user)->get(route('tourist-destinations.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Destinasi Wisata');
    }

    public function test_a_tourist_destination_create_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get(route('tourist-destinations.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Destinasi Wisata');
    }

    public function test_an_authenticated_user_can_create_new_tourist_destination()
    {
        $response = $this->actingAs($this->user)->post(route('tourist-destinations.store', [
            'name' => 'Pantai Konang',
            'sub_district_id' => $this->subDistrict->id,
            'tourist_destination_category_id' => $this->touristDestinationCategory->id,
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'manager' => 'LMDH',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir',
            'latitude' => '-8.274668036926231',
            'longitude' => '111.4529735413945',
            'description' => 'Terkenal dengan keindahan pantai dan kuliner ikan bakar',
        ]));
        $response->assertValid();
        $response->assertRedirect(route('tourist-destinations.index'));
        $response->assertSessionHasNoErrors();
    }
}
