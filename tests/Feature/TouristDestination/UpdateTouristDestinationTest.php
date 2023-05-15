<?php

namespace Tests\Feature\TouristDestination;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristAttraction;
use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTouristDestinationTest extends TestCase
{
    private User $user;

    private TouristDestination $touristDestination;

    private SubDistrict $subDistrict;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::disk('local')->put('public/cover-images/' . $image, '');

        $this->user = User::factory()->create();
        Category::factory()->create();
        $this->subDistrict = $this->subDistrict = SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => 'public/cover-images/' . $image,
        ]);
    }

    public function test_a_tourist_destination_edit_page_is_displayed()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/' . $this->touristDestination->slug . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Destinasi Wisata');
        $response->assertSessionHasNoErrors();

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

    public function test_an_authenticated_user_can_update_tourist_destination_without_change_any_not_required_field()
    {
        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'tourist_attraction_id' => [null],
            'tourist_attraction_names' => [null],
            'tourist_attraction_captions' => [null],
            'new_tourist_attraction_names' => [null],
            'new_tourist_attraction_images' => [null],
            'new_tourist_attraction_captions' => [null],
            'deleted_tourist_attractions' => [null],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(url()->previous());

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
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
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
            'tourist_attraction_id' => [null],
            'tourist_attraction_names' => [null],
            'tourist_attraction_captions' => [null],
            'new_tourist_attraction_names' => [null],
            'new_tourist_attraction_images' => [null],
            'new_tourist_attraction_captions' => [null],
            'deleted_tourist_attractions' => [null],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

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

    public function test_an_authenticated_user_can_update_tourist_destination_with_image_in_description_editor_and_remove_old_image_if_no_longer_used()
    {
        $image1 = UploadedFile::fake()->image('image1678273485413.png');
        $image2 = UploadedFile::fake()->image('image1678273485552.png');
        $this->touristDestination->addMedia($image1)->toMediaCollection('tourist-destinations');
        $this->touristDestination->addMedia($image2)->toMediaCollection('tourist-destinations');

        $this->assertTrue(Storage::exists('public/media/1/image1678273485413.png'));
        $this->assertTrue(Storage::exists('public/media/2/image1678273485552.png'));

        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'tourist_attraction_id' => [null],
            'tourist_attraction_names' => [null],
            'tourist_attraction_captions' => [null],
            'new_tourist_attraction_names' => [null],
            'new_tourist_attraction_images' => [null],
            'new_tourist_attraction_captions' => [null],
            'deleted_tourist_attractions' => [null],
            'media_files' => json_encode([
                'used_images' => [
                    [
                        'filename' => 'image1678273485413.png',
                    ],
                ],
                'unused_images' => [
                    [
                        'filename' => 'image1678273485552.png',
                    ],
                ],
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $tourisDestination = TouristDestination::first();

        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Konang Indah',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ]);
        // Use Spatie Media Libary Package
        $this->assertDatabaseHas('media', [
            'model_id' => $tourisDestination->id,
            'collection_name' => 'tourist-destinations',
            'file_name' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseMissing('media', [
            'model_id' => $tourisDestination->id,
            'collection_name' => 'tourist-destinations',
            'file_name' => 'image1678273485552.png',
        ]);
        $this->assertFalse(Storage::exists('public/media/2/image1678273485552.png'));
    }

    public function test_an_authenticated_user_can_update_tourist_destination_with_add_new_image_in_description_editor()
    {
        $this->actingAs($this->user)->postJson('/dashboard/images', [
            'image' => UploadedFile::fake()->image('image1678273485732.png'),
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485732.png',
        ]);

        $this->assertTrue(Storage::exists('public/tmp/media/images/image1678273485732.png'));

        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'tourist_attraction_id' => [null],
            'tourist_attraction_names' => [null],
            'tourist_attraction_captions' => [null],
            'new_tourist_attraction_names' => [null],
            'new_tourist_attraction_images' => [null],
            'new_tourist_attraction_captions' => [null],
            'deleted_tourist_attractions' => [null],
            'media_files' => json_encode([
                'used_images' => [
                    [
                        'filename' => 'image1678273485732.png',
                    ],
                ],
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $tourisDestination = TouristDestination::first();

        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Konang Indah',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ]);
        // Use Spatie Media Libary Package
        $this->assertDatabaseHas('media', [
            'model_id' => $tourisDestination->id,
            'collection_name' => 'tourist-destinations',
            'file_name' => 'image1678273485732.png',
        ]);
        $this->assertFalse(Storage::exists('public/tmp/media/images/image1678273485732.png'));
    }

    public function test_an_authenticated_user_can_update_tourist_destination_with_delete_existing_tourist_attraction()
    {
        Storage::disk('local')->put('public/tourist-attractions/attraction-1.jpg', '');
        Storage::disk('local')->put('public/tourist-attractions/attraction-2.jpg', '');
        DB::table('tourist_attractions')->insert([
            [
                'tourist_destination_id' => 1,
                'name' => 'Attraction 1',
                'image_name' => 'attraction-1.jpg',
                'image_path' => 'public/tourist-attractions/attraction-1.jpg',
                'caption' => 'Attraction 1 caption',
            ],
            [
                'tourist_destination_id' => 1,
                'name' => 'Attraction 2',
                'image_name' => 'attraction-2.jpg',
                'image_path' => 'public/tourist-attractions/attraction-2.jpg',
                'caption' => 'Attraction 2 caption',
            ],
        ]);

        $this->assertTrue(Storage::exists('public/tourist-attractions/attraction-1.jpg'));
        $this->assertTrue(Storage::exists('public/tourist-attractions/attraction-2.jpg'));

        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'tourist_attraction_id' => [null],
            'tourist_attraction_names' => [null],
            'tourist_attraction_captions' => [null],
            'new_tourist_attraction_names' => [null],
            'new_tourist_attraction_images' => [null],
            'new_tourist_attraction_captions' => [null],
            'deleted_tourist_attractions' => ['1,2'],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Konang Indah',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ]);
        $this->assertDatabaseMissing('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Attraction 1',
            'image_name' => 'attraction-1.jpg',
            'image_path' => 'public/tourist-attractions/attraction-1.jpg',
            'caption' => 'Attraction 1 caption',
        ]);
        $this->assertDatabaseMissing('tourist_attractions', [
            'tourist_destination_id' => 2,
            'name' => 'Attraction 2',
            'image_name' => 'attraction-2.jpg',
            'image_path' => 'public/tourist-attractions/attraction-2.jpg',
            'caption' => 'Attraction 2 caption',
        ]);
        $this->assertFalse(Storage::exists('public/tourist-attractions/attraction-1.jpg'));
        $this->assertFalse(Storage::exists('public/tourist-attractions/attraction-2.jpg'));
    }

    public function test_an_authenticated_user_can_update_tourist_destination_with_update_existing_tourist_attraction()
    {
        Storage::disk('local')->put('public/tourist-attractions/attraction-1.jpg', '');
        Storage::disk('local')->put('public/tourist-attractions/attraction-2.jpg', '');
        DB::table('tourist_attractions')->insert([
            [
                'tourist_destination_id' => 1,
                'name' => 'Attraction 1',
                'image_name' => 'attraction-1.jpg',
                'image_path' => 'public/tourist-attractions/attraction-1.jpg',
                'caption' => 'Attraction 1 caption',
            ],
            [
                'tourist_destination_id' => 1,
                'name' => 'Attraction 2',
                'image_name' => 'attraction-2.jpg',
                'image_path' => 'public/tourist-attractions/attraction-2.jpg',
                'caption' => 'Attraction 2 caption',
            ],
        ]);

        $this->assertTrue(Storage::exists('public/tourist-attractions/attraction-1.jpg'));
        $this->assertTrue(Storage::exists('public/tourist-attractions/attraction-2.jpg'));

        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'tourist_attraction_id' => [1, 2],
            'tourist_attraction_names' => ['Tourist Attraction 1', 'Tourist Attraction 2'],
            'tourist_attraction_captions' => ['Tourist Attraction 1 Caption', 'Tourist Attraction 2 Caption'],
            'new_tourist_attraction_names' => [null],
            'new_tourist_attraction_images' => [null],
            'new_tourist_attraction_captions' => [null],
            'deleted_tourist_attractions' => [null],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Konang Indah',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ]);
        $this->assertDatabaseMissing('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Attraction 1',
            'image_name' => 'attraction-1.jpg',
            'image_path' => 'public/tourist-attractions/attraction-1.jpg',
            'caption' => 'Attraction 1 caption',
        ]);
        $this->assertDatabaseMissing('tourist_attractions', [
            'tourist_destination_id' => 2,
            'name' => 'Attraction 2',
            'image_name' => 'attraction-2.jpg',
            'image_path' => 'public/tourist-attractions/attraction-2.jpg',
            'caption' => 'Attraction 2 caption',
        ]);
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Tourist Attraction 1',
            'image_name' => 'attraction-1.jpg',
            'image_path' => 'public/tourist-attractions/attraction-1.jpg',
            'caption' => 'Tourist Attraction 1 Caption',
        ]);
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Tourist Attraction 2',
            'image_name' => 'attraction-2.jpg',
            'image_path' => 'public/tourist-attractions/attraction-2.jpg',
            'caption' => 'Tourist Attraction 2 Caption',
        ]);
        $this->assertTrue(Storage::exists('public/tourist-attractions/attraction-1.jpg'));
        $this->assertTrue(Storage::exists('public/tourist-attractions/attraction-2.jpg'));
    }

    public function test_an_authenticated_user_can_update_tourist_destination_with_add_new_tourist_attraction()
    {
        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'tourist_attraction_id' => [null],
            'tourist_attraction_names' => [null],
            'tourist_attraction_captions' => [null],
            'new_tourist_attraction_names' => [
                'Air Terjun',
                'Gardu Pandang',
            ],
            'new_tourist_attraction_images' => [
                UploadedFile::fake()->create('air-terjun.jpg'),
                UploadedFile::fake()->create('gardu-pandang.jpg'),
            ],
            'new_tourist_attraction_captions' => [
                'Air terjun yang indah di pesisir pantai',
                'Gardu pandang yang menjangkau seluruh wilayah pesisi pantai',
            ],
            'deleted_tourist_attractions' => [null],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $tourisAttractions = TouristAttraction::where('tourist_destination_id', 1)->get();

        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Konang Indah',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ]);
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Air Terjun',
            'image_name' => $tourisAttractions[0]['image_name'],
            'image_path' => 'public/tourist-attractions/' . $tourisAttractions[0]['image_name'],
            'caption' => 'Air terjun yang indah di pesisir pantai',
        ]);
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Gardu Pandang',
            'image_name' => $tourisAttractions[1]['image_name'],
            'image_path' => 'public/tourist-attractions/' . $tourisAttractions[1]['image_name'],
            'caption' => 'Gardu pandang yang menjangkau seluruh wilayah pesisi pantai',
        ]);
        $this->assertTrue(Storage::exists('public/tourist-attractions/' . $tourisAttractions[0]['image_name']));
        $this->assertTrue(Storage::exists('public/tourist-attractions/' . $tourisAttractions[1]['image_name']));
    }

    public function test_a_guest_cannot_update_new_tourist_destination()
    {
        $response = $this->put('/dashboard/tourist-destinations/' . $this->touristDestination->slug, [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Dusun Nglebeng, Desa Nglebeng, Kecamatan Panggul',
            'description' => '<p>Terkenal dengan keindahan pantai dan kuliner olahan hasil laut</p>',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Food Court',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
            'tourist_attraction_names' => [null],
            'tourist_attraction_captions' => [null],
            'new_tourist_attraction_names' => [null],
            'new_tourist_attraction_images' => [null],
            'new_tourist_attraction_captions' => [null],
            'deleted_tourist_attractions' => [null],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertRedirect('/login');
        
        $this->assertGuest();
    }
}
