<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Tests\TestCase;

// Test case for update user password (Webgis Administrator)
class PasswordUpdateTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

    const MAIN_URL = '/dashboard/users/';

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@gmail.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_the_password_can_only_be_changed_if_the_password_confirmation_is_valid()
    {
        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->webgisAdmin->username, [
            'password' => 'newpassword',
            'password_confirmation' => 'wrongpassword',
        ]);

        $response->assertInvalid();
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasErrors(['password']);
    }

    public function test_webgis_admin_data_can_be_updated_with_change_password()
    {
        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->webgisAdmin->username, [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@gmail.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL . 'hugofirsttime/edit');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'hugofirsttime@gmail.com',
            'username' => 'hugofirsttime',
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'hugofirst@gmail.com',
            'username' => 'hugofirst',
        ]);
    }
}
