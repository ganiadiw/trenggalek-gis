<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private $avatar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->avatar = UploadedFile::fake()->image('avatar1.png')->hashName();

        Storage::disk('local')->put('public/avatars/' . $this->avatar, '');

        $this->user = User::factory()->create([
            'avatar_path' => 'public/avatars/' . $this->avatar,
            'avatar_name' => $this->avatar,
        ]);
    }

    public function test_profile_page_is_displayed()
    {
        $response = $this->actingAs($this->user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Profile');
        $response->assertSessionHasNoErrors();
    }

    public function test_profile_information_update_input_validation()
    {
        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => '',
            'username' => '',
            'email' => '',
        ]);
        $response->assertInvalid();
    }

    public function test_profile_information_can_be_updated_without_change_avatar()
    {
        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
        ]);
        $response->assertValid();
        $response->assertRedirect('/profile');
        $response->assertSessionHasNoErrors();
        $this->assertTrue(Storage::exists('public/avatars/' . $this->user->avatar_name));
        $this->assertDatabaseHas('users', [
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'hugofirst@example.com',
            'username' => 'hugofirst',
        ]);
    }

    public function test_profile_information_can_be_updated_with_change_avatar_and_remove_old_file()
    {
        $avatar = UploadedFile::fake()->image('avatar.png');

        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'avatar' => $avatar,
        ]);
        $response->assertValid();
        $response->assertRedirect('/profile');
        $response->assertSessionHasNoErrors();
        $this->assertFalse(Storage::exists('public/avatars/' . $this->avatar));
        $this->assertTrue(Storage::exists('public/avatars/' . $avatar->hashName()));
        $this->assertDatabaseHas('users', [
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'avatar_name' => $avatar->hashName(),
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'hugofirst@example.com',
            'username' => 'hugofirst',
        ]);
    }

    public function test_password_can_be_updated()
    {
        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'password' => 'qwertyuiop',
            'password_confirmation' => 'qwertyuiop',
        ]);
        $response->assertValid();
        $response->assertRedirect('/profile');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'hugofirst@example.com',
            'username' => 'hugofirst',
        ]);
    }
}
