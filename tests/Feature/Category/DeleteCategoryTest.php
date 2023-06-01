<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
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

    public function test_super_admin_can_delete_category()
    {
        $response = $this->actingAs($this->superAdmin)->delete(self::MAIN_URL .  $this->category->slug);

        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('categories', [
            'name' => $this->category->name,
        ]);
    }

    public function test_webgis_admin_cannot_delete_category()
    {
        $response = $this->actingAs($this->webgisAdmin)->delete(self::MAIN_URL .  $this->category->slug);

        $response->assertForbidden();
    }

    public function test_guest_cannot_delete_category()
    {
        $response = $this->delete(self::MAIN_URL .  $this->category->slug);

        $response->assertRedirect();

        $this->assertGuest();
    }
}
