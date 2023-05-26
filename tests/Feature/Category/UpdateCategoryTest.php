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

    const MAIN_URL = '/dashboard/categories/';

    private $data = [
        'name' => 'Wisata Pantai Pesisir'
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'is_admin' => 0,
        ]);
        $this->category = Category::factory()->create();

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_category_edit_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . $this->category->slug . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Kategori Destinasi Wisata');
        $response->assertSessionHasNoErrors();
    }

    public function test_category_update_input_validation()
    {
        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->category->slug, ['']);

        $response->assertInvalid(['name']);
    }

    public function test_super_admin_can_update_category_without_icon_marker()
    {
        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->category->slug, $this->data);

        $response->assertValid(['name']);
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('categories', $this->data);
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
    }

    public function test_super_admin_can_update_category_with_icon_marker()
    {
        $data = array_merge($this->data, [
            'color' => 'green',
            'svg_name' => 'apple-whole',
        ]);

        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->category->slug, $data);

        $response->assertValid(['name', 'color', 'svg_name']);
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('categories', $data);
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
    }

    public function test_webgis_admin_cannot_update_category()
    {
        $response = $this->actingAs($this->webgisAdmin)->put(self::MAIN_URL . $this->category->slug, $this->data);

        $response->assertForbidden();
    }

    public function test_guest_cannot_update_category()
    {
        $response = $this->put(self::MAIN_URL . $this->category->slug, $this->data);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
