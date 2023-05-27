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

    const TMP_IMAGE_PUBLIC_PATH = 'public/tmp/media/images';

    const ATTRACTION_IMAGE_PATH = 'public/tourist-attractions';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_post_a_temporary_image()
    {
        $response = $this->actingAs($this->user)->postJson(self::MAIN_URL, [
            'image' => UploadedFile::fake()->image('image1678273485413.png'),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'location' => '/storage/tmp/media/images/image1678273485413.png',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => self::TMP_IMAGE_PUBLIC_PATH,
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertTrue(Storage::exists(self::TMP_IMAGE_PUBLIC_PATH . '/image1678273485413.png'));
    }

    public function test_authenticated_user_can_delete_a_temporary_image()
    {
        Storage::disk('local')->put(self::TMP_IMAGE_PUBLIC_PATH . '/image1678273485413.png', '');
        TemporaryFile::create([
            'foldername' => self::TMP_IMAGE_PUBLIC_PATH,
            'filename' => 'image1678273485413.png',
        ]);

        $response = $this->actingAs($this->user)->deleteJson(self::MAIN_URL . '/image1678273485413.png');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Delete temporary file was successfully',
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => self::TMP_IMAGE_PUBLIC_PATH,
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertFalse(Storage::exists(self::TMP_IMAGE_PUBLIC_PATH . '/image1678273485413.png'));
    }

    public function test_authenticated_user_can_update_tourist_attraction_image()
    {
        SubDistrict::factory()->create();
        Category::factory()->create();
        TouristDestination::factory()->create();
        Storage::disk('local')->put(self::ATTRACTION_IMAGE_PATH . '/image123.jpg', '');
        $touristAttraction = TouristAttraction::create([
            'tourist_destination_id' => TouristDestination::first()->id,
            'name' => 'Tourist Attraction Name',
            'caption' => 'Touris Attraction Caption',
            'image_name' => 'image123.jpg',
            'image_path' => self::ATTRACTION_IMAGE_PATH . '/image123.jpg',
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
            'image_name' => 'image123.jpg',
            'image_path' => self::ATTRACTION_IMAGE_PATH . '/image123.jpg',
        ]);
        $this->assertTrue(Storage::exists(self::ATTRACTION_IMAGE_PATH . '/' . $touristAttraction->image_name));
        $this->assertFalse(Storage::exists(self::ATTRACTION_IMAGE_PATH . '/image123.jpg'));
    }
}
