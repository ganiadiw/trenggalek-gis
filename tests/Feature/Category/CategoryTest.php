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

    public function test_an_superadmin_can_see_category_management_page()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories');

        $response->assertSeeText('Kelola Data Kategori Destinasi Wisata');
        $response->assertSeeText('Destinasi Wisata');
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function test_an_webgis_admin_cannot_see_category_management_page()
    {
        $response = $this->actingAs($this->webgisAdmin)->get('/dashboard/categories');

        $response->assertForbidden();
    }

    public function test_an_guest_cannot_see_category_management_page()
    {
        $response = $this->get('/dashboard/categories');

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_an_superadmin_can_see_category_show_page()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories/' . $this->category->slug);

        $response->assertStatus(200);
        $response->assertSeeText('Informasi Kategori Destinasi Wisata');
        $response->assertSessionHasNoErrors();

        $this->assertEquals(1, $this->category->id);
        $this->assertEquals('Wisata Pantai', $this->category->name);
    }

    public function test_an_superadmin_can_search_contaions_category_data()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/categories/search?column_name=name&search_value=wisata');

        $response->assertSeeText($this->category->name);
        $response->assertSessionHasNoErrors();
    }
}
