<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    public function test_a_welcome_page_can_be_rendered()
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
