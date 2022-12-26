<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class TouristDestinationCategoryTest extends TestCase
{
    public function test_an_authenticated_user_can_see_tourist_category_management_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tourist-destination-categories.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kategori Destinasi Wisata');
    }
}
