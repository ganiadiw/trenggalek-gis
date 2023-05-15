<?php

namespace Tests\Feature\WebgisAdministrator;

use App\Models\User;
use Tests\TestCase;

// Test case for creating user (Webgis Administrator)
class CreateWebgisAdministratorTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

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

    public function test_a_webgis_administrator_create_page_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/users/create');

        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Administrator');
    }

    public function test_correct_data_must_be_provided_to_create_new_webgis_administrator()
    {
        $response = $this->actingAs($this->superAdmin)->post('/dashboard/users', [
            'name' => '',
            'email' => '',
            'username' => '',
            'password' => '',
            'address' => '',
            'phone_number' => '',
        ]);

        $response->assertInvalid();
        $response->assertRedirect(url()->previous());
    }

    public function test_an_superadmin_can_create_new_webgis_administrator()
    {
        $response = $this->actingAs($this->superAdmin)->post('/dashboard/users', [
            'name' => 'Lois Di Nominator',
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'is_admin' => 0,
            'password' => 'password',
        ]);

        $response->assertValid();
        $response->assertRedirect(route('dashboard.users.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
        ]);
    }

    public function test_an_webgis_administrator_cannot_create_new_webgis_administrator()
    {
        $response = $this->actingAs($this->webgisAdmin)->post('/dashboard/users', [
            'name' => 'Lois Di Nominator',
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'is_admin' => 0,
            'password' => 'password',
        ]);

        $response->assertForbidden();
    }

    public function test_an_guest_cannot_create_new_webgis_administrator()
    {
        $response = $this->post('/dashboard/users', [
            'name' => 'Lois Di Nominator',
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'is_admin' => 0,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        
        $this->assertGuest();
    }
}
