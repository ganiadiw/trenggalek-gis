<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    private User $superAdmin;

    private User $webgisAdmin;

    private Category $category;

    public function setUp(): void
    {
        parent::setUp();

        $image = UploadedFile::fake()->image('icon.jpg')->hashName();
        Storage::disk('local')->put('public/categories/icon/' . $image, '');

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
        $this->category = Category::factory()->create([
            'icon_name' => $image,
            'icon_path' => 'public/categories/icon/' . $image,
        ]);
    }

    public function test_an_superadmin_can_delete_category()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->delete('/dashboard/categories/' .  $this->category->slug);
        $response->assertRedirect(url()->previous());
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
    }

    public function test_an_superadmin_can_delete_category_with_icon_marker()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->delete('/dashboard/categories/' .  $this->category->slug);
        $response->assertRedirect(url()->previous());
        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
        $this->assertFalse(Storage::exists($this->category->icon_path));
    }

    public function test_an_webgis_administrator_cannot_delete_category()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->delete('/dashboard/categories/' .  $this->category->slug);
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_delete_category()
    {
        $response = $this->delete('/dashboard/categories/' .  $this->category->slug);
        $this->assertGuest();
        $response->assertRedirect();
    }
}
