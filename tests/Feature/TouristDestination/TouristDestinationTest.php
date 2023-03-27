<?php

namespace Tests\Feature\TouristDestination;

use App\Models\Category;
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

    private TouristDestination $touristDestination;

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::disk('local')->put('public/cover-images/' . $image, '');

        $this->user = User::factory()->create();
        Category::factory()->create();
        SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => 'public/cover-images/' . $image,
        ]);
    }

    public function test_an_authenticated_user_can_see_tourist_destination_management_page()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations');
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Destinasi Wisata');
    }

    public function test_an_authenticated_user_can_see_tourist_destinations_show_page()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/' . $this->touristDestination->slug);
        $response->assertRedirect('/tourist-destinations/' . $this->touristDestination->slug);
    }



    public function test_an_user_can_search_contains_tourist_destination_data()
    {
        $this->assertEquals(1, $this->user->is_admin);
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destinations/search', [
            'search' => $this->touristDestination->name,
        ]);
        $response->assertStatus(200);
        $response->assertSeeText($this->touristDestination->name);
    }
}
