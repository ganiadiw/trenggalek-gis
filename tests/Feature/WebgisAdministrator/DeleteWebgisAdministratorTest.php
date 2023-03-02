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

    public function test_an_superadmin_can_delete_webgis_administrator()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->delete('/dashboard/users/' . $this->webgisAdmin2->username);
        $response->assertRedirect('/dashboard/users');
        $this->assertDatabaseMissing('users', [
            'email' => 'johndoe@example.com',
        ]);
        Storage::disk('avatars')->assertMissing($this->webgisAdmin2->avatar_name);
    }

    public function test_an_webgis_administrator_cannot_delete_webgis_administrator()
    {
        $this->assertEquals(0, $this->webgisAdmin1->is_admin);
        $response = $this->actingAs($this->webgisAdmin1)->delete('/dashboard/users/' . $this->webgisAdmin2->username);
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_delete_webgis_administrator()
    {
        $response = $this->delete('/dashboard/users/' . $this->webgisAdmin2->username);
        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
