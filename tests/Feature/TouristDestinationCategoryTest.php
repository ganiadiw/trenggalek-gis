<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class TouristDestinationCategoryTest extends TestCase
{
    public function test_an_authenticated_user_can_see_tourist_destination_category_management_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tourist-destination-categories.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kategori Destinasi Wisata');
    }

    public function test_a_create_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tourist-destination-categories.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kategori Destinasi Wisata');
    }

    public function test_an_authenticated_user_can_create_new_tourist_destination_category()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tourist-destination-categories.store', [
            'name' => 'Wisata Pantai',
        ]));
        $response->assertValid();
        $response->assertRedirect();
    }
}
