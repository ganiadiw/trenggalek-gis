<?php

namespace Tests\Feature;

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
