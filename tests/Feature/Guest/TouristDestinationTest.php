<?php

namespace Tests\Feature\Guest;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TouristDestinationTest extends TestCase
{
    private TouristDestination $touristDestination;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::disk('local')->put('public/cover-images/' . $image, '');

        Category::factory()->create();
        SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => 'public/cover-images/' . $image,
        ]);
    }

    public function test_an_guest_can_see_tourist_destination_page()
    {
        $response = $this->get('/tourist-destinations/' . $this->touristDestination->slug);
        $response->assertStatus(200);
        $response->assertSeeText([$this->touristDestination->name, $this->touristDestination->address]);
    }
}
