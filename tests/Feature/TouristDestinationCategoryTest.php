<?php

namespace Tests\Feature;

use App\Models\TouristDestinationCategory;
use App\Models\User;
use Tests\TestCase;

class TouristDestinationCategoryTest extends TestCase
{
    private User $user; // Authenticated user (Super Admin and Webgis Administrator)

    private TouristDestinationCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = TouristDestinationCategory::factory()->create();
    }

    public function test_an_authenticated_user_can_see_tourist_destination_category_management_page()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destination-categories');
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kategori Destinasi Wisata');
    }

    public function test_a_tourist_destination_category_create_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destination-categories/create');
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kategori Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_create_new_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destination-categories', [
            'name' => '',
        ]);
        $response->assertInvalid(['name']);
    }

    public function test_an_authenticated_user_can_create_new_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->post('/dashboard/tourist-destination-categories', [
            'name' => 'Wisata Pantai',
        ]);
        $response->assertValid(['name']);
        $response->assertRedirect('/dashboard/tourist-destination-categories');
        $response->assertSessionHasNoErrors();
    }

    public function test_an_authenticated_user_can_see_tourist_destination_category_show_page()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destination-categories/' . $this->category->id);
        $response->assertStatus(200);
        $this->assertEquals('Wisata Pantai', $this->category->name);
    }

    public function test_a_tourist_destination_category_edit_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destination-categories/' . $this->category->id . '/edit');
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Kategori Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_update_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destination-categories/' . $this->category->id, [
            'name' => '',
        ]);
        $response->assertInvalid(['name']);
        $response->assertSessionHasErrors();
        $response->assertRedirect(url()->previous());
    }

    public function test_an_authenticated_user_can_update_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->put('/dashboard/tourist-destination-categories/' . $this->category->id, [
            'name' => 'Wisata Bahari',
        ]);
        $response->assertValid(['name']);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/dashboard/tourist-destination-categories');
    }

    public function test_an_authenticated_user_can_delete_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->delete('/dashboard/tourist-destination-categories/' . $this->category->id);
        $response->assertRedirect('/dashboard/tourist-destination-categories');
    }

    public function test_a_guest_cannot_create_new_tourist_destination_category()
    {
        $response = $this->post('/dashboard/tourist-destination-categories', [
            'name' => 'Wisata Pantai',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_a_guest_cannot_update_new_tourist_destination_category()
    {
        $response = $this->put('/dashboard/tourist-destination-categories/' . $this->category->id, [
            'name' => 'Wisata Bahari',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_a_guest_cannot_delete_new_tourist_destination_category()
    {
        $response = $this->delete('/dashboard/tourist-destination-categories/' . $this->category->id);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_an_user_can_search_contains_tourist_destination_category_data()
    {
        $this->assertEquals(1, $this->user->is_admin);
        $response = $this->actingAs($this->user)->get('/dashboard/tourist-destination-categories/search', [
            'search' => $this->category->name,
        ]);
        $response->assertStatus(200);
        $response->assertSeeText($this->category->name);
    }
}
