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

        $avatar1 = UploadedFile::fake()->image('avatar1.png')->hashName();
        $avatar2 = UploadedFile::fake()->image('avatar2.png')->hashName();
        Storage::disk('local')->put('public/avatars/' . $avatar1, '');
        Storage::disk('local')->put('public/avatars/' . $avatar2, '');

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin1 = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'avatar_path' => 'public/avatars/' . $avatar1,
            'avatar_name' => $avatar1,
            'is_admin' => 0,
        ]);

        $this->webgisAdmin2 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
            'avatar_path' => 'public/avatars/' . $avatar2,
            'avatar_name' => $avatar2,
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin1->is_admin);
        $this->assertEquals(0, $this->webgisAdmin2->is_admin);
    }

    public function test_a_edit_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/users/' . $this->webgisAdmin1->username . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Administrator');
        $response->assertSessionHasNoErrors();
    }

    public function test_correct_data_must_be_provided_to_update_webgis_administrator()
    {
        $response = $this->actingAs($this->superAdmin)->put('/dashboard/users/' . $this->webgisAdmin1->username, [
            'name' => '',
            'username' => '',
            'email' => '',
        ]);

        $response->assertInvalid();
        $response->assertRedirect(url()->previous());
    }

    public function test_an_superadmin_can_update_webgis_administrator_without_change_avatar()
    {
        $response = $this->actingAs($this->superAdmin)->put('/dashboard/users/' . $this->webgisAdmin1->username, [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
        ]);

        $response->assertValid();
        $response->assertRedirect('/dashboard/users/hugofirsttime/edit');
        $response->assertSessionHasNoErrors();

        $this->assertTrue(Storage::exists('public/avatars/' . $this->webgisAdmin1->avatar_name));
        $this->assertDatabaseHas('users', [
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'hugofirst@example.com',
            'username' => 'hugofirst',
        ]);
    }

    public function test_an_superadmin_can_update_webgis_administrator_with_change_avatar_and_remove_old_file()
    {
        $avatar = UploadedFile::fake()->image('avatar.png');

        $response = $this->actingAs($this->superAdmin)->put('/dashboard/users/' . $this->webgisAdmin1->username, [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'avatar' => $avatar,
        ]);

        $response->assertValid();
        $response->assertRedirect('/dashboard/users/hugofirsttime/edit');
        $response->assertSessionHasNoErrors();

        $this->assertFalse(Storage::exists('public/avatars/' . $this->webgisAdmin1->avatar_name));
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

    public function test_an_webgis_administrator_cannot_update_webgis_administrator()
    {
        $response = $this->actingAs($this->webgisAdmin1)->put('/dashboard/users/' . $this->webgisAdmin2->username, [
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
        $response = $this->put('/dashboard/users/' . $this->webgisAdmin1->username, [
            'name' => 'Micahel John Doe',
            'username' => 'johdoe_mic',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'michaeljohndoe@example.com',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
