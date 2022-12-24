<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_an_authenticated_user_can_see_dashboard_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSeeText('Dashboard');
    }

    public function test_an_unauthenticated_user_cannot_see_dashboard_page()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_an_superadmin_can_see_all_menu()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['Dashboard', 'Administrator WebGIS', 'Kecamatan', 'Kategori Destinasi Wisata', 'Destinasi Wisata', 'Desa Wisata']);
    }

    public function test_an_webgis_admin_cannot_see_superadmin_menu()
    {
        $user = User::factory()->make([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johdoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(0, $user->is_admin);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertDontSeeText('Administrator WebGIS');
        $response->assertDontSeeText('Data Kecamatan');
    }
}
