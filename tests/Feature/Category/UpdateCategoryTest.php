<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
    }

    public function test_a_category_edit_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get('dashboard/categories/' . $this->category->slug . '/edit');
        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Kategori Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_update_category()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => '',
        ]);
        $response->assertInvalid(['name']);
    }

    public function test_an_superadmin_can_update_category()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
        ]);
        $response->assertValid(['name']);
        $response->assertRedirect(url()->previous());
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
        $this->assertDatabaseHas('categories', [
            'name' => 'Wisata Pantai Pesisir',
        ]);
    }

    public function test_an_superadmin_can_update_category_with_icon_marker()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
            'color' => 'green',
            'svg_name' => 'apple-whole'
        ]);
        $response->assertValid(['name', 'color', 'svg_name']);
        $response->assertRedirect(url()->previous());
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
        $this->assertDatabaseHas('categories', [
            'name' => 'Wisata Pantai Pesisir',
            'color' => 'green',
            'svg_name' => 'apple-whole'
        ]);
    }

    public function test_an_webgis_admin_cannot_update_category()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
        ]);
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_update_category()
    {
        $response = $this->put('dashboard/categories/' . $this->category->slug, [
            'name' => 'Wisata Pantai Pesisir',
        ]);
        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
