<?php

namespace Tests\Feature\TouristDestination;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\User;
use DOMDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTouristDestinationTest extends TestCase
{
    private User $user;

    private Category $category;

    private SubDistrict $subDistrict;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::disk('local')->put('public/cover-images/' . $image, '');

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->subDistrict = SubDistrict::factory()->create();
    }

    public function test_tourist_destination_create_page_is_displayed()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/create');

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Destinasi Wisata');
    }

    public function test_tourist_destination_create_input_validation()
    {
        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destinations', [
            'name' => '',
        ]);

        $response->assertInvalid();
    }

    public function test_authenticated_user_can_create_tourist_destination_with_tourist_attraction()
    {
        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destinations', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => $this->category->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png'),
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'tourist_attraction_names' => [
                'Air Terjun',
                'Gardu Pandang',
            ],
            'tourist_attraction_images' => [
                UploadedFile::fake()->create('air-terjun.jpg'),
                UploadedFile::fake()->create('gardu-pandang.jpg'),
            ],
            'tourist_attraction_captions' => [
                'Air terjun yang indah di pesisir pantai',
                'Gardu pandang yang menjangkau seluruh wilayah pesisi pantai',
            ],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect('/dashboard/tourist-destinations');
        $response->assertSessionHasNoErrors();

        $touristDestinations = TouristDestination::with('TouristAttractions')->first();

        $this->assertTrue(Storage::exists('public/cover-images/' . $touristDestinations->cover_image_name));
        $this->assertTrue(Storage::exists('public/tourist-attractions/' . $touristDestinations->touristAttractions[0]->image_name));
        $this->assertTrue(Storage::exists('public/tourist-attractions/' . $touristDestinations->touristAttractions[1]->image_name));
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Pelang',
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
        ]);
        $this->assertDatabaseHas('tourist_attractions', [
            'id' => $touristDestinations->id,
            'name' => 'Air Terjun',
            'image_name' => $touristDestinations->touristAttractions[0]->image_name,
        ]);
    }

    public function test_authenticated_user_can_create_tourist_destination_without_tourist_attraction()
    {
        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destinations', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => $this->category->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png'),
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'tourist_attraction_names' => [null],
            'tourist_attraction_images' => [null],
            'tourist_attraction_captions' => [null],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect('/dashboard/tourist-destinations');
        $response->assertSessionHasNoErrors();

        $touristDestinations = TouristDestination::with('TouristAttractions')->first();

        $this->assertTrue(Storage::exists('public/cover-images/' . $touristDestinations->cover_image_name));
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Pelang',
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
        ]);
    }

    public function test_authenticated_user_can_create_tourist_destination_with_image_in_description_editor()
    {
        $this->actingAs($this->user)->postJson('/dashboard/images', [
            'image' => UploadedFile::fake()->image('image1678273485413.png'),
        ]);
        $this->actingAs($this->user)->postJson('/dashboard/images', [
            'image' => UploadedFile::fake()->image('image1678273485552.png'),
        ]);

        $this->assertDatabaseHas('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485552.png',
        ]);
        $this->assertTrue(Storage::exists('public/tmp/media/images/image1678273485413.png'));
        $this->assertTrue(Storage::exists('public/tmp/media/images/image1678273485552.png'));

        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destinations', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => $this->category->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png'),
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Pantai</p><img title="image1678273485413.png" src="../../storage/tmp/media/images/image1678273485413.png" alt=""><img title="image1678273485552.png" src="../../tmp/media/images/image1678273485552.png" alt="">',
            'tourist_attraction_names' => [null],
            'tourist_attraction_images' => [null],
            'tourist_attraction_captions' => [null],
            'media_files' => json_encode([
                'used_images' => [
                    [
                        'filename' => 'image1678273485413.png',
                    ],
                    [
                        'filename' => 'image1678273485552.png',
                    ],
                ],
                'unused_images' => null,
            ]),
        ]);

        $response->assertValid();
        $response->assertRedirect('/dashboard/tourist-destinations');
        $response->assertSessionHasNoErrors();

        $tourisDestination = TouristDestination::first();
        $dom = new DOMDocument();
        $dom->loadHTML($tourisDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $expectedDescription = '<p>Pantai<img title="image1678273485413.png" src="http://localhost:8000/storage/media/1/image1678273485413.png" alt=""><img title="image1678273485552.png" src="http://localhost:8000/storage/media/2/image1678273485552.png" alt=""></p>';

        $this->assertEquals(trim($expectedDescription), trim($dom->saveHTML()));
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Pelang',
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
        ]);
        // Use Spatie Media Libary Package
        $this->assertDatabaseHas('media', [
            'model_id' => $tourisDestination->id,
            'collection_name' => 'tourist-destinations',
            'file_name' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485552.png',
        ]);
        $this->assertFalse(Storage::exists('public/tmp/media/images/image1678273485413.png'));
        $this->assertFalse(Storage::exists('public/tmp/media/images/image1678273485552.png'));
    }

    public function test_authenticated_user_can_create_tourist_destination_with_deleted_image_in_description_editor()
    {
        $this->actingAs($this->user)->postJson('/dashboard/images', [
            'image' => UploadedFile::fake()->image('image1678273485413.png'),
        ]);
        $this->actingAs($this->user)->postJson('/dashboard/images', [
            'image' => UploadedFile::fake()->image('image1678273485552.png'),
        ]);

        $this->assertDatabaseHas('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485552.png',
        ]);
        $this->assertTrue(Storage::exists('public/tmp/media/images/image1678273485413.png'));
        $this->assertTrue(Storage::exists('public/tmp/media/images/image1678273485552.png'));

        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destinations', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => $this->category->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png'),
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Pantai</p><img title="image1678273485413.png" src="../../storage/tmp/media/images/image1678273485413.png" alt="">',
            'tourist_attraction_names' => [null],
            'tourist_attraction_images' => [null],
            'tourist_attraction_captions' => [null],
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
        $response->assertRedirect('/dashboard/tourist-destinations');
        $response->assertSessionHasNoErrors();

        $tourisDestination = TouristDestination::first();
        $dom = new DOMDocument();
        $dom->loadHTML($tourisDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $expectedDescription = '<p>Pantai<img title="image1678273485413.png" src="http://localhost:8000/storage/media/1/image1678273485413.png" alt=""></p>';

        $this->assertEquals(trim($expectedDescription), trim($dom->saveHTML()));
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Pantai Pelang',
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
        ]);
        // Use Spatie Media Libary Package
        $this->assertDatabaseHas('media', [
            'model_id' => $tourisDestination->id,
            'collection_name' => 'tourist-destinations',
            'file_name' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485552.png',
        ]);
        $this->assertFalse(Storage::exists('public/tmp/media/images/image1678273485413.png'));
        $this->assertFalse(Storage::exists('public/tmp/media/images/image1678273485552.png'));
    }

    public function test_guest_cannot_create_tourist_destination()
    {
        $response = $this->post('dashboard/tourist-destinations', [
            'name' => 'Pantai Pelang',
            'sub_district_id' => json_encode($this->subDistrict),
            'category_id' => $this->category->id,
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'manager' => 'DISPARBUD',
            'distance_from_city_center' => '56 KM',
            'transportation_access' => 'Bisa diakses dengan bus, mobil, dan sepeda motor',
            'facility' => 'MCK, Mushola, Lahan Parkir, Camping Ground, Kios Kuliner',
            'cover_image' => UploadedFile::fake()->create('pantai-pelang.png'),
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
            'description' => '<p>Salah satu pantai yang mempunyai air terjun di pesisir pantainya</p>',
            'tourist_attraction_names' => [null],
            'tourist_attraction_images' => [null],
            'tourist_attraction_captions' => [null],
            'media_files' => json_encode([
                'used_images' => null,
                'unused_images' => null,
            ]),
        ]);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
