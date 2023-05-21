<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class MapDrawerTest extends TestCase
{
    public function test_map_drawer_page_is_displayed()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get('/dashboard/map-drawer');

        $response->assertStatus(200);
        $response->assertSeeText('Map Drawer');
        $response->assertSessionHasNoErrors();
    }
}
