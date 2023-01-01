<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TouristDestinationTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_an_authenticated_user_can_see_tourist_destination_management_page()
    {
        $response = $this->actingAs($this->user)->get(route('tourist-destinations.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Destinasi Wisata');
    }
}
