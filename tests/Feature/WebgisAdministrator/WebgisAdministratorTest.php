<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Tests\TestCase;

// Test case for other user (Webgis Administrator) operation
class WebgisAdministratorTest extends TestCase
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

    public function test_super_admin_can_visit_the_webgis_admin_management_page()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL);

        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Administrator');
    }

    public function test_webgis_admin_cannot_visit_the_webgis_admin_management_page()
    {
        $response = $this->actingAs($this->webgisAdmin)->get(self::MAIN_URL);

        $response->assertForbidden();
    }

    public function test_guest_cannot_visit_the_webgis_admin_management_page()
    {
        $response = $this->get(self::MAIN_URL);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_super_admin_can_search_contains_webgis_admin_data()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . 'search?column_name=name&search_value=hugo');

        $response->assertStatus(200);
        $response->assertSeeText($this->webgisAdmin->name);
        $response->assertSessionHasNoErrors();
    }

    public function test_notification_is_displayed_for_search_not_found_webgis_admin_data()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . 'search?column_name=name&search_value=john');

        $response->assertStatus(200);
        $response->assertSeeText('Data tidak tersedia');
        $response->assertSessionHasNoErrors();
    }

    public function test_webgis_admin_profile_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . $this->webgisAdmin->username);

        $response->assertStatus(200);
        $response->assertSeeText('Detail Profil');
        $response->assertSessionHasNoErrors();

        $this->assertEquals('Hugo First', $this->webgisAdmin->name);
        $this->assertEquals('hugofirst', $this->webgisAdmin->username);
        $this->assertEquals('Desa Gayam, Kecamatan Panggul', $this->webgisAdmin->address);
        $this->assertEquals('081234567890', $this->webgisAdmin->phone_number);
        $this->assertEquals('hugofirst@gmail.com', $this->webgisAdmin->email);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_route_redirect_to_profile_update_for_self_data_update()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . $this->superAdmin->username . '/edit');

        $response->assertRedirect(route('profile.edit'));
    }
}
