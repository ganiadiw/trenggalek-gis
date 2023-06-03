<?php

namespace Tests\Feature\Guest;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TouristDestinationTest extends TestCase
{
    private TouristDestination $touristDestination;

    const COVER_IMAGE_PATH = 'cover-images/';

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::put(self::COVER_IMAGE_PATH . $image, '');

        Category::factory()->create();
        SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => self::COVER_IMAGE_PATH . $image,
        ]);
    }

    public function test_guest_can_visit_the_tourist_destination_page()
    {
        $response = $this->get('tourist-destinations/' . $this->touristDestination->slug);

        $response->assertStatus(200);
        $response->assertSeeText([$this->touristDestination->name, $this->touristDestination->address]);
        $response->assertSessionHasNoErrors();
    }
}
