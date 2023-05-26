<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    private User $user;

    const MAIN_URL = '/dashboard';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_visit_the_dashboard_page()
    {
        $response = $this->actingAs($this->user)->get(self::MAIN_URL);

        $response->assertStatus(200);
        $response->assertSeeText('Dashboard');
        $response->assertSessionHasNoErrors();
    }

    public function test_guest_cannot_visit_the_dashboard_page()
    {
        $response = $this->get(self::MAIN_URL);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_super_admin_can_see_all_menu()
    {
        $this->assertEquals(1, $this->user->is_admin);

        $response = $this->actingAs($this->user)->get(self::MAIN_URL);

        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['Dashboard', 'Administrator WebGIS', 'Kecamatan', 'Kategori Destinasi Wisata', 'Destinasi Wisata', 'Map Drawer', 'Halaman Pengunjung']);
        $response->assertSessionHasNoErrors();
    }

    public function test_webgis_admin_cannot_see_super_admin_menu()
    {
        $webgisAdmin = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johdoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(0, $webgisAdmin->is_admin);

        $response = $this->actingAs($webgisAdmin)->get(self::MAIN_URL);

        $response->assertStatus(200);
        $response->assertDontSeeText('Administrator WebGIS');
        $response->assertDontSeeText('Data Kecamatan');
        $response->assertSessionHasNoErrors();
    }
}
