<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
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

    public function test_category_edit_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('dashboard/categories/' . $this->category->slug . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Kategori Destinasi Wisata');
        $response->assertSessionHasNoErrors();
    }

    public function test_category_update_input_validation()
    {
        $response = $this->actingAs($this->superAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => '',
        ]);

        $response->assertInvalid(['name']);
    }

    public function test_super_admin_can_update_category_without_icon_marker()
    {
        $response = $this->actingAs($this->superAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
        ]);

        $response->assertValid(['name']);
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'name' => 'Wisata Pantai Pesisir',
        ]);
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
    }

    public function test_super_admin_can_update_category_with_icon_marker()
    {
        $response = $this->actingAs($this->superAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
            'color' => 'green',
            'svg_name' => 'apple-whole',
        ]);

        $response->assertValid(['name', 'color', 'svg_name']);
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'name' => 'Wisata Pantai Pesisir',
            'color' => 'green',
            'svg_name' => 'apple-whole',
        ]);
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
    }

    public function test_webgis_admin_cannot_update_category()
    {
        $response = $this->actingAs($this->webgisAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
        ]);

        $response->assertForbidden();
    }

    public function test_guest_cannot_update_category()
    {
        $response = $this->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
        ]);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
