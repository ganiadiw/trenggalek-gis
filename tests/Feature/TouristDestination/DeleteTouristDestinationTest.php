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

class DeleteTouristDestinationTest extends TestCase
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

    public function test_an_authenticated_user_can_delete_tourist_destination()
    {
        $response = $this->actingAs($this->user)->delete('/dashboard/tourist-destinations/' . $this->touristDestination->slug);
        $response->assertRedirect(url()->previous());
        $this->assertFalse(Storage::exists('public/cover-images/' . $this->touristDestination->cover_image_name));
        $this->assertDatabaseMissing('tourist_destinations', [
            'id' => $this->touristDestination->id,
            'name' => 'Pantai Konang',
            'address' => 'Desa Nglebeng, Kecamatan Panggul',
            'slug' => $this->touristDestination->slug,
        ]);
    }

    public function test_a_guest_cannot_delete_new_tourist_destination()
    {
        $response = $this->delete('/dashboard/tourist-destinations/' . $this->touristDestination->id);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
