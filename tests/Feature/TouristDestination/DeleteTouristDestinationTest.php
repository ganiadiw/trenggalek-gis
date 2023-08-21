<?php

namespace Tests\Feature\TouristDestination;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristAttraction;
use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteTouristDestinationTest extends TestCase
{
    private User $user;

    private TouristDestination $touristDestination;

    const MAIN_URL = '/dashboard/tourist-destinations/';

    const COVER_IMAGE_PATH = 'cover-images/';

    protected function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('pantai-konang.jpg')->hashName();
        Storage::put(self::COVER_IMAGE_PATH . $image, '');

        $this->user = User::factory()->create();
        Category::factory()->create();
        SubDistrict::factory()->create();
        $this->touristDestination = TouristDestination::factory()->create([
            'cover_image_name' => $image,
            'cover_image_path' => self::COVER_IMAGE_PATH . $image,
        ]);
    }

    public function test_authenticated_user_can_delete_tourist_destination()
    {
        $response = $this->actingAs($this->user)->delete(self::MAIN_URL . $this->touristDestination->slug);

        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertFalse(Storage::exists(self::COVER_IMAGE_PATH . $this->touristDestination->cover_image_name));
        $this->assertDatabaseMissing('tourist_destinations', [
            'id' => $this->touristDestination->id,
            'name' => 'Pantai Konang',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'slug' => $this->touristDestination->slug,
        ]);
    }

    public function test_tourist_attractions_can_be_deleted_when_tourist_destination_is_deleted()
    {
        $image = UploadedFile::fake()->image('atraksi-1.jpg')->hashName();

        $touristAttraction = TouristAttraction::query()->create([
            'tourist_destination_id' => $this->touristDestination->id,
            'name' => 'Gardu Pandang',
            'image_name' => $image,
            'image_path' => 'tourist-attractions/' . $image,
            'caption' => 'Gardu pandang yang indah',
        ]);

        $response = $this->actingAs($this->user)->delete(self::MAIN_URL . $this->touristDestination->slug);

        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertFalse(Storage::exists(self::COVER_IMAGE_PATH . $this->touristDestination->cover_image_name));
        $this->assertFalse(Storage::exists('tourist-attractions/' . $image));
        $this->assertDatabaseMissing('tourist_destinations', [
            'id' => $this->touristDestination->id,
            'name' => 'Pantai Konang',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'slug' => $this->touristDestination->slug,
        ]);
        $this->assertDatabaseMissing('tourist_attractions', [
            'id' => $touristAttraction->id,
            'name' => 'Gardu Pandang',
            'image_name' => $image,
            'image_path' => 'tourist-attractions/' . $image,
            'caption' => 'Gardu pandang yang indah',
        ]);
    }

    public function test_guest_cannot_delete_tourist_destination()
    {
        $response = $this->delete(self::MAIN_URL . $this->touristDestination->id);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
