<?php

namespace Tests\Feature\Category;

use App\Models\User;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    private User $superAdmin;

    private User $webgisAdmin;

    public function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'address' => 'Desa Panggul, Kecamatan Panggul',
            'phone_number' => '081234567890',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_a_category_create_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories/create');

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kategori Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_create_category()
    {
        $response = $this->actingAs($this->superAdmin)->post('/dashboard/categories', [
            'name' => '',
        ]);

        $response->assertInvalid(['name']);
    }

    public function test_an_superadmin_can_create_category()
    {
        $response = $this->actingAs($this->superAdmin)->post('/dashboard/categories', [
            'name' => 'Wisata Pertanian',
        ]);

        $response->assertValid(['name']);
        $response->assertRedirect('/dashboard/categories');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'name' => 'Wisata Pertanian',
        ]);
    }

    public function test_an_superadmin_can_create_category_with_icon_marker()
    {
        $response = $this->actingAs($this->superAdmin)->post('/dashboard/categories', [
            'name' => 'Wisata Pertanian',
            'color' => 'green',
            'svg_name' => 'apple-whole',
        ]);

        $response->assertValid(['name', 'color', 'svg_name']);
        $response->assertRedirect('/dashboard/categories');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'name' => 'Wisata Pertanian',
            'color' => 'green',
            'svg_name' => 'apple-whole',
        ]);
    }

    public function test_an_webgis_administrator_cannot_create_category()
    {
        $response = $this->actingAs($this->webgisAdmin)->post('/dashboard/categories', [
            'name' => 'Wisata Pertanian',
        ]);

        $response->assertForbidden();
    }

    public function test_an_guest_cannot_create_category()
    {
        $response = $this->post('/dashboard/categories', [
            'name' => 'Wisata Pertanian',
        ]);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
