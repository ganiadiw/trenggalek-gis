<?php

namespace Tests\Feature\Category;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    private User $superAdmin;

    private User $webgisAdmin;

    const MAIN_URL = '/dashboard/categories/';

    private $data = [
        'name' => 'Wisata Pertanian',
    ];

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

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_category_create_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . 'create');

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kategori Destinasi Wisata');
    }

    public function test_category_create_input_validation()
    {
        $response = $this->actingAs($this->superAdmin)->post(self::MAIN_URL, ['']);

        $response->assertInvalid(['name']);
    }

    public function test_super_admin_can_create_category_without_custom_icon_marker()
    {
        $response = $this->actingAs($this->superAdmin)->post(self::MAIN_URL, $this->data);

        $response->assertValid(['name']);
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('categories', $this->data);
    }

    public function test_super_admin_can_create_category_with_icon_marker()
    {
        $customMarker = UploadedFile::fake()->image('marker.png');

        $this->data = array_merge($this->data, [
            'marker_text_color' => '#C6AA2C',
            'custom_marker' => $customMarker,
        ]);

        $response = $this->actingAs($this->superAdmin)->post(self::MAIN_URL, $this->data);

        $response->assertValid(['name', 'marker_text_color', 'custom_marker_name']);
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $this->assertTrue(Storage::exists('categories/custom-marker/' . $customMarker->hashName()));
        $this->assertDatabaseHas('categories', [
            'name' => 'Wisata Pertanian',
            'marker_text_color' => '#C6AA2C',
            'custom_marker_name' => $customMarker->hashName(),
        ]);
    }

    public function test_webgis_admin_cannot_create_category()
    {
        $response = $this->actingAs($this->webgisAdmin)->post(self::MAIN_URL, $this->data);

        $response->assertForbidden();
    }

    public function test_guest_cannot_create_category()
    {
        $response = $this->post(self::MAIN_URL, $this->data);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
