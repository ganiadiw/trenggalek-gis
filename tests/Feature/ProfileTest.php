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

    const MAIN_URL = '/profile';

    const AVATAR_PATH = 'public/avatars/';

    private $data = [
        'name' => 'Hugo First Time',
        'email' => 'hugofirsttime@gmail.com',
        'username' => 'hugofirsttime',
        'address' => 'Desa Sumberbening, Kecamatan Dongko',
        'phone_number' => '081234567890',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->avatar = UploadedFile::fake()->image('avatar1.png')->hashName();

        Storage::disk('local')->put(self::AVATAR_PATH . $this->avatar, '');

        $this->user = User::factory()->create([
            'avatar_path' => self::AVATAR_PATH . $this->avatar,
            'avatar_name' => $this->avatar,
        ]);
    }

    public function test_profile_page_is_displayed()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL);

        $response->assertStatus(200);
        $response->assertSeeText('Edit Profile');
        $response->assertSessionHasNoErrors();
    }

    public function test_profile_information_update_input_validation()
    {
        $response = $this->actingAs($this->user)->put(self::MAIN_URL, ['']);
        $response->assertInvalid();
    }

    public function test_profile_information_can_be_updated_without_change_avatar()
    {
        $response = $this->actingAs($this->user)->put(self::MAIN_URL, $this->data);

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $this->assertTrue(Storage::exists(self::AVATAR_PATH . $this->user->avatar_name));
        $this->assertDatabaseHas('users', $this->data);
        $this->assertDatabaseMissing('users', [$this->user]);
    }

    public function test_profile_information_can_be_updated_with_change_avatar_and_remove_old_file()
    {
        $avatar2 = UploadedFile::fake()->image('avatar.png');

        $response = $this->actingAs($this->user)->put(self::MAIN_URL, array_merge($this->data, ['avatar' => $avatar2]));

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $this->assertFalse(Storage::exists(self::AVATAR_PATH . $this->avatar));
        $this->assertTrue(Storage::exists(self::AVATAR_PATH . $avatar2->hashName()));
        $this->assertDatabaseHas('users', array_merge($this->data, ['avatar_name' => $avatar2->hashName()]));
        $this->assertDatabaseMissing('users', [$this->user]);
    }

    public function test_password_can_be_updated()
    {
        $dataWithPassword = array_merge($this->data, [
            'password' => 'qwertyuiop',
            'password_confirmation' => 'qwertyuiop',
        ]);

        $response = $this->actingAs($this->user)->put(self::MAIN_URL, $dataWithPassword);

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', $this->data);
        $this->assertDatabaseMissing('users', [$this->user]);
    }
}
