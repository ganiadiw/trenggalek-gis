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

    const MAIN_URL = '/dashboard/categories/';

    public function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@gmail.com',
            'is_admin' => 0,
        ]);
        $this->category = Category::factory()->create();

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_super_admin_can_visit_the_category_management_page()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL);

        $response->assertSeeText('Kelola Data Kategori Destinasi Wisata');
        $response->assertSeeText('Destinasi Wisata');
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function test_webgis_admin_cannot_visit_the_category_management_page()
    {
        $response = $this->actingAs($this->webgisAdmin)->get(self::MAIN_URL);

        $response->assertForbidden();
    }

    public function test_guest_cannot_visit_the_category_management_page()
    {
        $response = $this->get(self::MAIN_URL);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_super_admin_can_search_contains_category_data()
    {
        $response = $this->actingAs($this->superAdmin)
                    ->get(self::MAIN_URL . 'search?column_name=name&search_value=wisata');

        $response->assertStatus(200);
        $response->assertSeeText($this->category->name);
        $response->assertSessionHasNoErrors();
    }

    public function test_notification_is_displayed_for_search_not_found_category_data()
    {
        $response = $this->actingAs($this->superAdmin)
                    ->get(self::MAIN_URL . 'search?column_name=name&search_value=123');

        $response->assertStatus(200);
        $response->assertSeeText('Data tidak tersedia');
        $response->assertSessionHasNoErrors();
    }

    public function test_category_show_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . $this->category->slug);

        $response->assertStatus(200);
        $response->assertSeeText('Detail Informasi Kategori Destinasi Wisata');
        $response->assertSessionHasNoErrors();

        $this->assertEquals(1, $this->category->id);
        $this->assertEquals('Wisata Pantai', $this->category->name);
        $this->assertEquals('wisata-pantai-12345', $this->category->slug);
    }
}
