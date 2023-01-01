<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

// Test case for updating user (Webgis Administrator)
class UpdateWebgisAdministratorTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin1; // Webgis Administrator

    private User $webgisAdmin2; // Webgis Administrator

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('avatars');
        $avatar = UploadedFile::fake()->image('avatar.png');

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin1 = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'avatar_path' => $avatar->path(),
            'avatar_name' => $avatar->hashName(),
            'is_admin' => 0,
        ]);

        $this->webgisAdmin2 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
            'avatar_path' => $avatar->path(),
            'avatar_name' => $avatar->hashName(),
            'is_admin' => 0,
        ]);
    }

    public function test_a_edit_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('users.edit', ['user' => $this->webgisAdmin1]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_correct_data_must_be_provided_to_update_webgis_administrator()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put(route('users.update', ['user' => $this->webgisAdmin1]), [
            'name' => '',
            'username' => '',
            'email' => '',
            'username' => '',
        ]);
        $response->assertInvalid();
        $response->assertRedirect(url()->previous());
    }

    public function test_an_superadmin_can_update_webgis_administrator_without_change_avatar_and_password()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put(route('users.update', ['user' => $this->webgisAdmin1]), [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
        ]);
        $response->assertValid();
        $response->assertRedirect(route('users.index'));
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

    public function test_an_superadmin_can_update_webgis_administrator_with_change_avatar()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        Storage::fake('avatars');

        $avatar = UploadedFile::fake()->image('avatar.png');
        $updateData = [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'avatar' => $avatar,
        ];

        if ($updateData['avatar']) {
            $updateData['avatar_path'] = $avatar->path();
            $updateData['avatar_name'] = $avatar->hashName();

            if ($this->webgisAdmin1['avatar_path'] != null) {
                Storage::disk('avatars')->delete($this->webgisAdmin1['avatar_path']);
            }
        }

        $response = $this->actingAs($this->superAdmin)->put(route('users.update', ['user' => $this->webgisAdmin1]), $updateData);
        $response->assertValid();
        $response->assertRedirect(route('users.index'));
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

    public function test_an_webgis_administrator_cannot_update_webgis_administrator()
    {
        $this->assertEquals(0, $this->webgisAdmin1->is_admin);
        $response = $this->actingAs($this->webgisAdmin1)->put(route('users.update', ['user' => $this->webgisAdmin2]), [
            'name' => 'Micahel John Doe',
            'username' => 'johdoe_mic',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'michaeljohndoe@example.com',
        ]);
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_update_webgis_administrator()
    {
        $response = $this->put(route('users.update', ['user' => $this->webgisAdmin1]), [
            'name' => 'Micahel John Doe',
            'username' => 'johdoe_mic',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'michaeljohndoe@example.com',
        ]);
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
