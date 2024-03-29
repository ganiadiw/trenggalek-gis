<?php

namespace Tests\Feature\TouristDestination;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TouristDestinationTest extends TestCase
{
    private User $user;

    private TouristDestination $touristDestination;

    const MAIN_URL = '/dashboard/tourist-destinations/';

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::put('cover-images/' . $image, '');

        $this->user = User::factory()->create();
        Category::factory()->create();
        SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => 'cover-images/' . $image,
        ]);
    }

    public function test_authenticated_user_can_visit_the_tourist_destination_management_page()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL);

        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Destinasi Wisata');
        $response->assertSessionHasNoErrors();
    }

    public function test_guest_cannot_visit_the_tourist_destination_management_page()
    {
        $response = $this->get(self::MAIN_URL);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_authenticated_user_can_search_contains_tourist_destination_data()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL . 'search?column_name=name&search_value=konang');

        $response->assertStatus(200);
        $response->assertSeeText($this->touristDestination->name);
        $response->assertSessionHasNoErrors();
    }

    public function test_notification_is_displayed_for_search_not_found_tourist_destination_data()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL . 'search?column_name=name&search_value=gadsdee');

        $response->assertStatus(200);
        $response->assertSeeText('Data tidak tersedia');
        $response->assertSessionHasNoErrors();
    }

    public function test_route_redirect_to_guest_tourist_destination_show_page()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL . $this->touristDestination->slug);

        $response->assertRedirect('/tourist-destinations/' . $this->touristDestination->slug);
        $response->assertSessionHasNoErrors();
    }
}
