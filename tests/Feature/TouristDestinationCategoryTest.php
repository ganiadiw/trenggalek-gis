<?php

namespace Tests\Feature;

use App\Models\TouristDestinationCategory;
use App\Models\User;
use Tests\TestCase;

class TouristDestinationCategoryTest extends TestCase
{
    private User $user;

    private TouristDestinationCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = TouristDestinationCategory::factory()->create();
    }

    public function test_an_authenticated_user_can_see_tourist_destination_category_management_page()
    {
        $response = $this->actingAs($this->user)->get(route('tourist-destination-categories.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kategori Destinasi Wisata');
    }

    public function test_a_create_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get(route('tourist-destination-categories.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kategori Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_create_new_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->post(route('tourist-destination-categories.store', [
            'name' => '',
        ]));
        $response->assertInvalid();
    }

    public function test_an_authenticated_user_can_create_new_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->post(route('tourist-destination-categories.store', [
            'name' => 'Wisata Pantai',
        ]));
        $response->assertValid();
        $response->assertRedirect();
    }

    public function test_an_authenticated_user_can_see_tourist_destination_category_show_page()
    {
        $response = $this->actingAs($this->user)->get(route('tourist-destination-categories.show', ['tourist_destination_category' => $this->category]));
        $response->assertStatus(200);
        $this->assertEquals('Wisata Pantai', $this->category->name);
    }

    public function test_a_edit_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get(route('tourist-destination-categories.edit', ['tourist_destination_category' => $this->category]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Kategori Destinasi Wisata');
    }

    public function test_correct_data_must_be_provided_to_update_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->put(route('tourist-destination-categories.update', ['tourist_destination_category' => $this->category]), [
            'name' => '',
        ]);
        $response->assertInvalid();
    }

    public function test_an_authenticated_user_can_update_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->put(route('tourist-destination-categories.update', ['tourist_destination_category' => $this->category]), [
            'name' => 'Wisata Bahari',
        ]);
        $response->assertValid();
        $response->assertRedirect(route('tourist-destination-categories.index'));
    }

    public function test_an_authenticated_user_can_delete_tourist_destination_category()
    {
        $response = $this->actingAs($this->user)->delete(route('tourist-destination-categories.destroy', ['tourist_destination_category' => $this->category]));
        $response->assertRedirect(route('tourist-destination-categories.index'));
    }
}
