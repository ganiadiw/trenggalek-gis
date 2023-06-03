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
    const MAIN_URL = '/dashboard/tourist-destinations/';

    const IMAGE_UPLOAD_URL = '/dashboard/images';

    const COVER_IMAGE_PATH = 'cover-images/';

    const TMP_IMAGE_PATH = 'tmp/media/images';

    const IMAGE1 = 'image1678273485413.png';

    const IMAGE2 = 'image1678273485552.png';

    const ATTRACTION_IMAGE_PATH = 'tourist-attractions/';

    private User $user;

    private Category $category;

    private SubDistrict $subDistrict;

    private $data;

    private $dataToCheck;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-pelang.jpg')->hashName();
        Storage::put(self::COVER_IMAGE_PATH . $image, '');

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->subDistrict = SubDistrict::factory()->create();
        $this->data = [
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
        ];
        $this->dataToCheck = [
            'name' => 'Pantai Pelang',
            'address' => 'Desa Wonocoyo, Kecamatan Panggul',
            'latitude' => -8.25702326,
            'longitude' => 111.42379872,
        ];
    }

    public function test_tourist_destination_create_page_is_displayed()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL . 'create');

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Destinasi Wisata');
    }

    public function test_tourist_destination_create_input_validation()
    {
        $response = $this->actingAs($this->user)->post(self::MAIN_URL, ['']);

        $response->assertInvalid();
    }

    public function test_authenticated_user_can_create_tourist_destination_with_tourist_attraction()
    {
        $touristAttractions = [
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
        ];

        $response = $this->actingAs($this->user)->post(self::MAIN_URL, array_merge($this->data, $touristAttractions));

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $touristDestinations = TouristDestination::with('TouristAttractions')->first();

        $this->assertTrue(Storage::exists(self::COVER_IMAGE_PATH . $touristDestinations->cover_image_name));
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . $touristDestinations->touristAttractions[0]->image_name));
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . $touristDestinations->touristAttractions[1]->image_name));
        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        $this->assertDatabaseHas('tourist_attractions', [
            'id' => $touristDestinations->id,
            'name' => 'Air Terjun',
            'image_name' => $touristDestinations->touristAttractions[0]->image_name,
        ]);
    }

    public function test_authenticated_user_can_create_tourist_destination_without_tourist_attraction()
    {
        $response = $this->actingAs($this->user)->post(self::MAIN_URL, $this->data);

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $touristDestinations = TouristDestination::with('TouristAttractions')->first();

        $this->assertTrue(Storage::exists(self::COVER_IMAGE_PATH . $touristDestinations->cover_image_name));
        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
    }

    public function test_authenticated_user_can_create_tourist_destination_with_image_in_description_editor()
    {
       $this->postImage();

        $description = [
            'description' => '<p>Pantai</p><img title="image1678273485413.png" src="../../storage/tmp/media/images/image1678273485413.png" alt=""><img title="image1678273485552.png" src="../../tmp/media/images/image1678273485552.png" alt="">',
            'media_files' => json_encode([
                'used_images' => [
                    [
                        'filename' => self::IMAGE1,
                    ],
                    [
                        'filename' => self::IMAGE2,
                    ],
                ],
                'unused_images' => null,
            ]),
        ];

        $response = $this->actingAs($this->user)->post(self::MAIN_URL, array_merge($this->data, $description));

        $response->assertValid();
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(self::MAIN_URL);

        $dom = new DOMDocument();
        $tourisDestination = TouristDestination::first();
        $dom->loadHTML($tourisDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $expectedDescription = '<p>Pantai<img title="image1678273485413.png" src="http://localhost:8000/storage/media/1/image1678273485413.png" alt=""><img title="image1678273485552.png" src="http://localhost:8000/storage/media/2/image1678273485552.png" alt=""></p>';

        $this->assertValue($expectedDescription, $dom, $tourisDestination);
    }

    public function test_authenticated_user_can_create_tourist_destination_with_deleted_image_in_description_editor()
    {
        $this->postImage();

        $description = [
            'description' => '<p>Pantai</p><img title="image1678273485413.png" src="../../storage/tmp/media/images/image1678273485413.png" alt="">',
            'media_files' => json_encode([
                'used_images' => [
                    [
                        'filename' => self::IMAGE1,
                    ],
                ],
                'unused_images' => [
                    [
                        'filename' => self::IMAGE2,
                    ],
                ],
            ]),
        ];
        $response = $this->actingAs($this->user)->post(self::MAIN_URL, array_merge($this->data, $description));

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $tourisDestination = TouristDestination::first();
        $dom = new DOMDocument();
        $dom->loadHTML($tourisDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $expectedDescription = '<p>Pantai<img title="image1678273485413.png" src="http://localhost:8000/storage/media/1/image1678273485413.png" alt=""></p>';

        $this->assertValue($expectedDescription, $dom, $tourisDestination);
    }

    public function test_guest_cannot_create_tourist_destination()
    {
        $response = $this->post(self::MAIN_URL, $this->data);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    private function postImage()
    {
        $this->actingAs($this->user)->postJson(self::IMAGE_UPLOAD_URL, [
            'image' => UploadedFile::fake()->image(self::IMAGE1),
        ]);
        $this->actingAs($this->user)->postJson(self::IMAGE_UPLOAD_URL, [
            'image' => UploadedFile::fake()->image(self::IMAGE2),
        ]);

        $this->assertDatabaseHas('temporary_files', [
            'foldername' => self::TMP_IMAGE_PATH,
            'filename' => self::IMAGE1,
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => self::TMP_IMAGE_PATH,
            'filename' => self::IMAGE2,
        ]);
        $this->assertTrue(Storage::exists(self::TMP_IMAGE_PATH . '/' . self::IMAGE1));
        $this->assertTrue(Storage::exists(self::TMP_IMAGE_PATH . '/' . self::IMAGE2));
    }

    private function assertValue($expectedDescription, $dom, $tourisDestination)
    {
        $this->assertEquals(trim($expectedDescription), trim($dom->saveHTML()));
        $this->assertDatabaseHas('tourist_destinations', $this->dataToCheck);
        // Use Spatie Media Libary Package
        $this->assertDatabaseHas('media', [
            'model_id' => $tourisDestination->id,
            'collection_name' => 'tourist-destinations',
            'file_name' => self::IMAGE1,
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => self::TMP_IMAGE_PATH,
            'filename' => self::IMAGE1,
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => self::TMP_IMAGE_PATH,
            'filename' => self::IMAGE2,
        ]);
        $this->assertFalse(Storage::exists(self::TMP_IMAGE_PATH . '/' . self::IMAGE1));
        $this->assertFalse(Storage::exists(self::TMP_IMAGE_PATH . '/' . self::IMAGE2));
    }
}
