<?php

namespace Tests\Feature\TouristDestination;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristAttraction;
use App\Models\TouristDestination;
use App\Models\User;
use DOMDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTouristDestinationTest extends TestCase
{
    const MAIN_URL = '/dashboard/tourist-destinations/';

    const IMAGE_UPLOAD_URL = '/dashboard/images';

    const COVER_IMAGE_PATH = 'public/cover-images/';

    const TMP_IMAGE_PATH = 'public/tmp/media/images';

    const ATTRACTION_IMAGE_PATH = 'public/tourist-attractions/';

    private User $user;

    private TouristDestination $touristDestination;

    private SubDistrict $subDistrict;

    private $data;

    private $dataToCheck;

    private $missingData;

    private $touristAttraction1;

    private $touristAttraction2;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::disk('local')->put(self::COVER_IMAGE_PATH . $image, '');

        $this->user = User::factory()->create();
        Category::factory()->create();
        $this->subDistrict = $this->subDistrict = SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => self::COVER_IMAGE_PATH . $image,
        ]);
        $this->data = [
            'sub_district_id' => $this->subDistrict->id,
            'category_id' => 1,
            'name' => 'Pantai Konang Indah',
            'manager' => 'LDMH',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
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
        ];
        $this->dataToCheck = [
            'name' => 'Pantai Konang Indah',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ];
        $this->missingData = [
            'name' => 'Pantai Konang',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'latitude' => -8.27466803,
            'longitude' => 111.45297354,
        ];

        Storage::disk('local')->put(self::ATTRACTION_IMAGE_PATH . 'attraction-1.jpg', '');
        Storage::disk('local')->put(self::ATTRACTION_IMAGE_PATH . 'attraction-2.jpg', '');

        $this->touristAttraction1 = [
            'tourist_destination_id' => 1,
            'name' => 'Attraction 1',
            'image_name' => 'attraction-1.jpg',
            'image_path' => self::ATTRACTION_IMAGE_PATH . 'attraction-1.jpg',
            'caption' => 'Attraction 1 caption',
        ];
        $this->touristAttraction2 = [
            'tourist_destination_id' => 1,
            'name' => 'Attraction 2',
            'image_name' => 'attraction-2.jpg',
            'image_path' => self::ATTRACTION_IMAGE_PATH . 'attraction-2.jpg',
            'caption' => 'Attraction 2 caption',
        ];

        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . 'attraction-1.jpg'));
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . 'attraction-2.jpg'));
    }

    public function test_tourist_destination_edit_page_is_displayed()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL . $this->touristDestination->slug . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Destinasi Wisata');
        $response->assertSessionHasNoErrors();

        $this->assertEquals('Pantai Konang', $this->touristDestination->name);
        $this->assertEquals('Desa Nglebeng, Kecamatan Panggul', $this->touristDestination->address);
        $this->assertEquals('-8.27466803', $this->touristDestination->latitude);
        $this->assertEquals('111.45297354', $this->touristDestination->longitude);
    }

    public function test_tourist_destination_update_input_validation()
    {
        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, ['']);

        $response->assertInvalid();
    }

    public function test_authenticated_user_can_update_tourist_destination()
    {
        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, $this->data);

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        $this->assertDatabaseMissing('tourist_destinations', $this->missingData);
    }

    public function test_authenticated_user_can_update_tourist_destination_with_change_cover_image()
    {
        $coverImage = UploadedFile::fake()->image('pantai-konang-indah.jpg');

        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, array_merge($this->data, ['cover_image' => $coverImage]));

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertFalse(Storage::exists(self::COVER_IMAGE_PATH . $this->touristDestination->cover_image_name));
        $this->assertTrue(Storage::exists(self::COVER_IMAGE_PATH . $coverImage->hashName()));
        $this->assertDatabaseHas('tourist_destinations', array_merge($this->dataToCheck, ['cover_image_name' => $coverImage->hashName()]));
        $this->assertDatabaseMissing('tourist_destinations', $this->missingData);
    }

    public function test_authenticated_user_can_update_tourist_destination_with_delete_image_in_description_editor()
    {
        $image1 = UploadedFile::fake()->image('image1678273485413.png');
        $image2 = UploadedFile::fake()->image('image1678273485552.png');
        $this->touristDestination->addMedia($image1)->toMediaCollection('tourist-destinations');
        $this->touristDestination->addMedia($image2)->toMediaCollection('tourist-destinations');

        $this->assertTrue(Storage::exists('public/media/1/image1678273485413.png'));
        $this->assertTrue(Storage::exists('public/media/2/image1678273485552.png'));

        $description = [
            'description' => '<p>Pantai<img title="image1678273485413.png" src="http://localhost:8000/storage/media/1/image1678273485413.png" alt=""></p>',
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
        ];

        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, array_merge($this->data, $description));

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $tourisDestination = TouristDestination::first();
        $dom = new DOMDocument();
        $dom->loadHTML($tourisDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $expectedDescription = '<p>Pantai<img title="image1678273485413.png" src="http://localhost:8000/storage/media/1/image1678273485413.png" alt=""></p>';

        $this->assertEquals(trim($expectedDescription), trim($dom->saveHTML()));
        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        $this->assertDatabaseMissing('tourist_destinations', $this->missingData);
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

    public function test_authenticated_user_can_update_tourist_destination_with_add_new_image_in_description_editor()
    {
        $this->actingAs($this->user)->postJson(self::IMAGE_UPLOAD_URL, [
            'image' => UploadedFile::fake()->image('image1678273485732.png'),
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => self::TMP_IMAGE_PATH,
            'filename' => 'image1678273485732.png',
        ]);

        $this->assertTrue(Storage::exists(self::TMP_IMAGE_PATH . '/image1678273485732.png'));

        $description = [
            'description' => '<p>Pantai</p><img title="image1678273485732.png" src="../../storage/tmp/media/images/image1678273485732.png" alt="">',
            'media_files' => json_encode([
                'used_images' => [
                    [
                        'filename' => 'image1678273485732.png',
                    ],
                ],
                'unused_images' => null,
            ]),
        ];

        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, array_merge($this->data, $description));

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $tourisDestination = TouristDestination::first();
        $dom = new DOMDocument();
        $dom->loadHTML($tourisDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $expectedDescription = '<p>Pantai<img title="image1678273485732.png" src="http://localhost:8000/storage/media/1/image1678273485732.png" alt=""></p>';

        $this->assertEquals(trim($expectedDescription), trim($dom->saveHTML()));
        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        $this->assertDatabaseMissing('tourist_destinations', $this->missingData);
        // Use Spatie Media Libary Package
        $this->assertDatabaseHas('media', [
            'model_id' => $tourisDestination->id,
            'collection_name' => 'tourist-destinations',
            'file_name' => 'image1678273485732.png',
        ]);
        $this->assertFalse(Storage::exists(self::TMP_IMAGE_PATH . '/image1678273485732.png'));
    }

    public function test_authenticated_user_can_update_tourist_destination_with_delete_existing_tourist_attraction()
    {
        DB::table('tourist_attractions')->insert([$this->touristAttraction1, $this->touristAttraction2]);

        $touristAttraction = [
            'deleted_tourist_attractions' => ['1,2'],
        ];

        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, array_merge($this->data, $touristAttraction));

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        $this->assertFalse(Storage::exists(self::ATTRACTION_IMAGE_PATH . 'attraction-1.jpg'));
        $this->assertFalse(Storage::exists(self::ATTRACTION_IMAGE_PATH . 'attraction-2.jpg'));
        $this->assertDatabaseMissing('tourist_attractions', $this->touristAttraction1);
        $this->assertDatabaseMissing('tourist_attractions', $this->touristAttraction2);
    }

    public function test_authenticated_user_can_update_tourist_destination_with_update_existing_tourist_attraction()
    {
        DB::table('tourist_attractions')->insert([$this->touristAttraction1, $this->touristAttraction2]);

        $touristAttractionData = [
            'tourist_attraction_id' => [1, 2],
            'tourist_attraction_names' => ['Tourist Attraction 1', 'Tourist Attraction 2'],
            'tourist_attraction_captions' => ['Tourist Attraction 1 Caption', 'Tourist Attraction 2 Caption'],
        ];

        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, array_merge($this->data, $touristAttractionData));

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        $this->assertDatabaseMissing('tourist_attractions', $this->touristAttraction1);
        $this->assertDatabaseMissing('tourist_attractions', $this->touristAttraction2);
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . 'attraction-1.jpg'));
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . 'attraction-2.jpg'));
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Tourist Attraction 1',
            'image_name' => 'attraction-1.jpg',
            'image_path' => self::ATTRACTION_IMAGE_PATH . 'attraction-1.jpg',
            'caption' => 'Tourist Attraction 1 Caption',
        ]);
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Tourist Attraction 2',
            'image_name' => 'attraction-2.jpg',
            'image_path' => self::ATTRACTION_IMAGE_PATH . 'attraction-2.jpg',
            'caption' => 'Tourist Attraction 2 Caption',
        ]);
    }

    public function test_authenticated_user_can_update_tourist_destination_with_add_new_tourist_attraction()
    {
        $tourisAttractionsData = [
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
        ];

        $response = $this->actingAs($this->user)->put(self::MAIN_URL . $this->touristDestination->slug, array_merge($this->data, $tourisAttractionsData));

        $response->assertValid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $tourisAttractions = TouristAttraction::where('tourist_destination_id', 1)->get();

        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Air Terjun',
            'image_name' => $tourisAttractions[0]['image_name'],
            'image_path' => self::ATTRACTION_IMAGE_PATH . $tourisAttractions[0]['image_name'],
            'caption' => 'Air terjun yang indah di pesisir pantai',
        ]);
        $this->assertDatabaseHas('tourist_attractions', [
            'tourist_destination_id' => 1,
            'name' => 'Gardu Pandang',
            'image_name' => $tourisAttractions[1]['image_name'],
            'image_path' => self::ATTRACTION_IMAGE_PATH . $tourisAttractions[1]['image_name'],
            'caption' => 'Gardu pandang yang menjangkau seluruh wilayah pesisi pantai',
        ]);
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . $tourisAttractions[0]['image_name']));
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . $tourisAttractions[1]['image_name']));
    }

    public function test_guest_cannot_update_tourist_destination()
    {
        $response = $this->put(self::MAIN_URL . $this->touristDestination->slug, $this->data);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
