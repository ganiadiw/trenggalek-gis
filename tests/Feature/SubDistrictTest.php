<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubDistrictTest extends TestCase
{
    public function test_an_superadmin_can_see_sub_district_management_page()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get('/dashboard/sub-districts');
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kecamatan');
    }
}
