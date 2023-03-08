<?php

namespace Tests\Feature\TouristDestination;

use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\TouristDestinationCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTouristDestinationTest extends TestCase
{
    private User $user;

    private TouristDestination $touristDestination;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::disk('local')->put('public/cover-images/' . $image, '');

        $this->user = User::factory()->create();
        TouristDestinationCategory::factory()->create();
        SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => 'public/cover-images/' . $image,
        ]);
    }
    public function test_a_tourist_destination_edit_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/' . $this->touristDestination->slug . '/edit');
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Destinasi Wisata');
        $this->assertEquals('Pantai Konang', $this->touristDestination->name);
        $this->assertEquals('Desa Nglebeng, Kecamatan Panggul', $this->touristDestination->address);
        $this->assertEquals('-8.27466803', $this->touristDestination->latitude);
        $this->assertEquals('111.45297354', $this->touristDestination->longitude);
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

    public function test_an_authenticated_user_can_update_tourist_destination_without_change_cover_image()
    {
        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => 1,
            'tourist_destination_category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(url()->previous());
        $this->assertTrue(Storage::exists('public/cover-images/' . $this->touristDestination->cover_image_name));
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Konang Indah',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
        ]);
        $this->assertDatabaseMissing('tourist_destinations', [
            'name' => 'Pantai Konang',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner ikan bakar</p>',
            'facility' => 'MCK, Mushola, Lahan Parkir',
        ]);
    }

    public function test_an_authenticated_user_can_update_tourist_destination_with_change_cover_image()
    {
        $coverImage = UploadedFile::fake()->image('pantai-konang-indah.jpg');

        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => 1,
            'tourist_destination_category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'cover_image' => $coverImage,
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);
        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(url()->previous());
        $this->assertFalse(Storage::exists('public/cover-images/' . $this->touristDestination->cover_image_name));
        $this->assertTrue(Storage::exists('public/cover-images/' . $coverImage->hashName()));
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Konang Indah',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'cover_image_name' => $coverImage->hashName(),
        ]);
        $this->assertDatabaseMissing('tourist_destinations', [
            'name' => 'Pantai Konang',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner ikan bakar</p>',
            'facility' => 'MCK, Mushola, Lahan Parkir',
        ]);
    }

    public function test_a_guest_cannot_update_new_tourist_destination()
    {
        $response = $this->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => 1,
            'tourist_destination_category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
