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
        $response = $this->actingAs($this->superAdmin)->delete(route('dashboard.users.destroy', ['user' => $this->webgisAdmin2]));

        if ($this->webgisAdmin2['avatar_path'] != null) {
            Storage::disk('avatars')->delete($this->webgisAdmin2['avatar_path']);
        }

        $response->assertRedirect(route('dashboard.users.index'));
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($this->webgisAdmin2);
        Storage::disk('avatars')->assertMissing('avatar.png');
    }

    public function test_an_webgis_administrator_cannot_delete_webgis_administrator()
    {
        $this->assertEquals(0, $this->webgisAdmin1->is_admin);
        $response = $this->actingAs($this->webgisAdmin1)->delete(route('dashboard.users.destroy', ['user' => $this->webgisAdmin2]));
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_delete_webgis_administrator()
    {
        $response = $this->delete(route('dashboard.users.update', ['user' => $this->webgisAdmin1]));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
