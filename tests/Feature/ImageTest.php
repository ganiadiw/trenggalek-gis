<?php

namespace Tests\Feature;

use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_an_authenticated_use_can_post_an_temporary_image_file()
    {
        $response = $this->actingAs($this->user)->postJson('/dashboard/images', [
            'image' => UploadedFile::fake()->image('image1678273485413.png'),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'location' => '/storage/tmp/media/images/image1678273485413.png',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertDatabaseHas('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertTrue(Storage::exists('public/tmp/media/images/image1678273485413.png'));
    }

    public function test_an_authenticated_use_can_delete_an_temporary_image_file()
    {
        Storage::disk('local')->put('public/cover-images/image1678273485413.png', '');
        TemporaryFile::create([
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485413.png',
        ]);

        $response = $this->actingAs($this->user)->deleteJson('/dashboard/images/image1678273485413.png');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Delete temporary file was successfully',
        ]);
        $this->assertDatabaseMissing('temporary_files', [
            'foldername' => 'public/tmp/media/images',
            'filename' => 'image1678273485413.png',
        ]);
        $this->assertFalse(Storage::exists('public/tmp/media/images/image1678273485413.png'));
    }
}
