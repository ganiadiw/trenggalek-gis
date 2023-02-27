<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Tests\TestCase;

// Test case for other user (Webgis Administrator) operation
class WebgisAdministratorTest extends TestCase
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

    public function test_an_superadmin_can_see_webgis_administrator_management_page()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.users.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_an_superadmin_can_search_contains_webgis_administrator_data()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.users.search'), [
            'search' => $this->webgisAdmin->name,
        ]);
        $response->assertSeeText($this->webgisAdmin->name);
    }

    public function test_an_superadmin_cannot_search_contains_no_webgis_administrator_data()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->actingAs($this->superAdmin)->get(route('dashboard.users.search'), [
            'search' => 'John',
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => 'John',
        ]);
    }

    public function test_an_superadmin_can_see_webgis_administrator_profile()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.users.show', ['user' => $this->webgisAdmin]));
        $response->assertStatus(200);
        $this->assertEquals('Hugo First', $this->webgisAdmin->name);
        $this->assertEquals('hugofirst', $this->webgisAdmin->username);
        $this->assertEquals('Desa Gayam, Kecamatan Panggul', $this->webgisAdmin->address);
        $this->assertEquals('081234567890', $this->webgisAdmin->phone_number);
        $this->assertEquals('hugofirst@example.com', $this->webgisAdmin->email);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_an_superadmin_redirect_to_profile_update_route_if_want_to_change_the_data_itself()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('dashboard.users.edit', ['user' => $this->superAdmin->username]));
        $response->assertRedirect(route('profile.edit'));
    }
}
