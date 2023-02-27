<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

// Test case for update user password (Webgis Administrator)
class PasswordUpdateTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'is_admin' => 0,
        ]);
    }

    public function test_an_superadmin_cannot_update_webgis_administrator_with_incorrect_password()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $updateData = [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'new_password' => 'newpassword',
            'password_confirmation' => 'wrongpassword',
        ];

        if ($updateData['password_confirmation'] != $updateData['new_password']) {
            $response = $this->actingAs($this->superAdmin)->put(route('dashboard.users.update', ['user' => $this->webgisAdmin]), $updateData);
            $response->assertRedirect(url()->previous());
        }
    }

    public function test_an_superadmin_can_update_webgis_administrator_with_change_correct_password()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $updateData = [
            'name' => 'Hugo First Time',
            'email' => 'hugofirsttime@example.com',
            'username' => 'hugofirsttime',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'new_password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        if ($updateData['password_confirmation'] == $updateData['new_password']) {
            $updateData['password'] = Hash::make($updateData['new_password']);
            $response = $this->actingAs($this->superAdmin)->put(route('dashboard.users.update', ['user' => $this->webgisAdmin]), $updateData);
            $response->assertValid();
            $response->assertRedirect(route('dashboard.users.index'));
        }

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
