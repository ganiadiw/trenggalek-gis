<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Tests\TestCase;

class CreateWebgisAdministratorTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

    const MAIN_URL = '/dashboard/users/';

    private $data = [
        'name' => 'Lois Di Nominator',
        'email' => 'loisdinominator@example.com',
        'username' => 'loisdinominator',
        'address' => 'Desa Cakul, Kecamatan Dongko',
        'phone_number' => '081234567890',
        'is_admin' => 0,
        'password' => 'password',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $this->superAdmin->is_admin);
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
    }

    public function test_webgis_admin_create_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . 'create');

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Administrator');
    }

    public function test_webgis_admin_create_input_validation()
    {
        $response = $this->actingAs($this->superAdmin)->post(self::MAIN_URL, ['']);

        $response->assertInvalid();
        $response->assertRedirect(url()->previous());
    }

    public function test_super_admin_can_create_webgis_admin()
    {
        $response = $this->actingAs($this->superAdmin)->post(self::MAIN_URL, $this->data);

        $response->assertValid();
        $response->assertRedirect(self::MAIN_URL);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
        ]);
    }

    public function test_webgis_admin_cannot_create_webgis_admin()
    {
        $response = $this->actingAs($this->webgisAdmin)->post(self::MAIN_URL, $this->data);

        $response->assertForbidden();
    }

    public function test_guest_cannot_create_webgis_admin()
    {
        $response = $this->post(self::MAIN_URL, $this->data);

        $response->assertRedirect('/login');

        $this->assertGuest();
    }
}
