<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    const MAIN_URL = '/confirm-password';

    public function test_confirm_password_screen_is_displayed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(self::MAIN_URL);

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(self::MAIN_URL, [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(self::MAIN_URL, [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
