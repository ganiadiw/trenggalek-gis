<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

// Test case for deleting user (Webgis Administrator)
class DeleteWebgisAdministratorTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin1; // Webgis Administrator

    private User $webgisAdmin2; // Webgis Administrator

    const MAIN_URL = '/dashboard/users/';

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

    public function test_super_admin_can_delete_webgis_admin()
    {
        $response = $this->actingAs($this->superAdmin)->delete(self::MAIN_URL . $this->webgisAdmin2->username);

        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertFalse(Storage::exists('public/avatars/' . $this->webgisAdmin2->avatar_name));
        $this->assertDatabaseMissing('users', [
            'email' => 'johndoe@example.com',
        ]);
    }

    public function test_webgis_admin_cannot_delete_webgis_admin()
    {
        $this->assertEquals(0, $this->webgisAdmin1->is_admin);

        $response = $this->actingAs($this->webgisAdmin1)->delete(self::MAIN_URL . $this->webgisAdmin2->username);
        $response->assertForbidden();
    }

    public function test_guest_cannot_delete_webgis_admin()
    {
        $response = $this->delete(self::MAIN_URL . $this->webgisAdmin2->username);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
