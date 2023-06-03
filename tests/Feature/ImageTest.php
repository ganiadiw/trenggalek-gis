<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TemporaryFile;
use App\Models\TouristAttraction;
use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageTest extends TestCase
{
    private User $user;

    const MAIN_URL = '/dashboard/images';

    const TMP_IMAGE_PUBLIC_PATH = 'tmp/media/images';

    const ATTRACTION_IMAGE_PATH = 'tourist-attractions';

    const IMAGE1 = 'image1678273485413.png';

    const IMAGE2 = 'image123.jpg';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_post_a_temporary_image()
    {
        $response = $this->actingAs($this->user)->postJson(self::MAIN_URL, [
            'image' => UploadedFile::fake()->image(self::IMAGE1),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'location' => 'http://localhost:8000/storage/tmp/media/images/' . self::IMAGE1,
            'filename' => self::IMAGE1,
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => self::TMP_IMAGE_PUBLIC_PATH,
            'filename' => self::IMAGE1,
        ]);
        $this->assertTrue(Storage::exists(self::TMP_IMAGE_PUBLIC_PATH . '/' . self::IMAGE1));
    }

    public function test_authenticated_user_can_delete_a_temporary_image()
    {
        Storage::put(self::TMP_IMAGE_PUBLIC_PATH . '/' . self::IMAGE1, '');
        TemporaryFile::create([
            'foldername' => self::TMP_IMAGE_PUBLIC_PATH,
            'filename' => self::IMAGE1,
        ]);

        $response = $this->actingAs($this->user)->deleteJson(self::MAIN_URL . '/' . self::IMAGE1);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Delete temporary file was successfully',
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => self::TMP_IMAGE_PUBLIC_PATH,
            'filename' => self::IMAGE1,
        ]);
        $this->assertFalse(Storage::exists(self::TMP_IMAGE_PUBLIC_PATH . '/' . self::IMAGE1));
    }

    public function test_authenticated_user_can_update_tourist_attraction_image()
    {
        SubDistrict::factory()->create();
        Category::factory()->create();
        TouristDestination::factory()->create();
        Storage::put(self::ATTRACTION_IMAGE_PATH . '/' . self::IMAGE2, '');
        $touristAttraction = TouristAttraction::create([
            'tourist_destination_id' => TouristDestination::first()->id,
            'name' => 'Tourist Attraction Name',
            'caption' => 'Touris Attraction Caption',
            'image_name' => self::IMAGE2,
            'image_path' => self::ATTRACTION_IMAGE_PATH . '/' . self::IMAGE2,
        ]);

        $response = $this->actingAs($this->user)->postJson(self::MAIN_URL . '/tourist-attraction/update', [
            'id' => $touristAttraction->id,
            'image' => UploadedFile::fake()->image('image2.jpg'),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Update image was successfully',
        ]);
        $touristAttraction = TouristAttraction::first();
        $this->assertDatabaseHas('tourist_attractions', [
            'image_name' => $touristAttraction->image_name,
            'image_path' => $touristAttraction->image_path,
        ]);
        $this->assertDatabaseMissing('tourist_attractions', [
            'image_name' => self::IMAGE2,
            'image_path' => self::ATTRACTION_IMAGE_PATH . '/' . self::IMAGE2,
        ]);
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . '/' . $touristAttraction->image_name));
        $this->assertFalse(Storage::exists(self::ATTRACTION_IMAGE_PATH . '/' . self::IMAGE2));
    }
}
