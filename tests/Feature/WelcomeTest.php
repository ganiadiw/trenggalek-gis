<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomeTest extends TestCase
{
    public function test_welcome_page_is_displayed()
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Wisata Trenggalek');
        $response->assertSessionHasNoErrors();
    }
}
