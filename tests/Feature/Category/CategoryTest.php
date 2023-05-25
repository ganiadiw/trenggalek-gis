<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private User $superAdmin;

    private User $webgisAdmin;

    private Category $category;

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
        $this->category = Category::factory()->create();

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_super_admin_can_visit_the_category_management_page()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories');

        $response->assertSeeText('Kelola Data Kategori Destinasi Wisata');
        $response->assertSeeText('Destinasi Wisata');
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function test_webgis_admin_cannot_visit_the_category_management_page()
    {
        $response = $this->actingAs($this->webgisAdmin)->get('/dashboard/categories');

        $response->assertForbidden();
    }

    public function test_guest_cannot_visit_the_category_management_page()
    {
        $response = $this->get('/dashboard/categories');

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_super_admin_can_search_contains_category_data()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories/search?column_name=name&search_value=wisata');

        $response->assertStatus(200);
        $response->assertSeeText($this->category->name);
        $response->assertSessionHasNoErrors();
    }

    public function test_notification_is_displayed_for_search_not_found_category_data()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories/search?column_name=name&search_value=123');

        $response->assertStatus(200);
        $response->assertSeeText('Data tidak tersedia');
        $response->assertSessionHasNoErrors();
    }

    public function test_category_show_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories/' . $this->category->slug);

        $response->assertStatus(200);
        $response->assertSeeText('Detail Informasi Kategori Destinasi Wisata');
        $response->assertSessionHasNoErrors();

        $this->assertEquals(1, $this->category->id);
        $this->assertEquals('Wisata Pantai', $this->category->name);
        $this->assertEquals('wisata-pantai-12345', $this->category->slug);
    }
}
