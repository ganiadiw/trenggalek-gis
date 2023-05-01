<?php

namespace Tests\Feature\PageSetting;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    public function test_an_authenticated_user_can_see_page_setting_page()
    {
        $response = $this->actingAs($this->user)->get('/dashboard/page-setting/welcome');
        $response->assertStatus(200);
        $response->assertSeeText('Pengaturan Halaman');
    }
}
