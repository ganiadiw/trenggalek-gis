<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class WebgisAdministratorTest extends TestCase
{
    private User $superAdmin; // Super Admin

    private User $webgisAdmin; // Webgis Administrator

    private User $otherUser; // User data target for other needs (Webgis Administrator)

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->webgisAdmin = User::factory()->create([
            'name' => 'Hugo First',
            'username' => 'hugofirst',
            'email' => 'hugofirst@example.com',
            'address' => 'Desa Panggul, Kecamatan Panggul',
            'phone_number' => '081234567890',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'is_admin' => 0,
        ]);
        $this->otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'is_admin' => 0,
        ]);
    }

    public function test_an_superadmin_can_see_webgis_administrator_management_page()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_a_webgis_administrator_create_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('users.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_an_superadmin_can_search_contains_webgis_administrator_data()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('users.search'), [
            'search' => $this->otherUser->name,
        ]);
        $response->assertSeeText($this->otherUser->name);
    }

    // public function test_an_superadmin_can_search_contains_no_webgis_administrator_data()
    // {
    //     $user = User::factory()->create();

    //     $this->assertEquals(1, $user->is_admin);
    //     $response = $this->actingAs($user)->get(route('users.search'), [
    //         'search' => 'W',
    //     ]);
    //     $response->assertSeeText('Data tidak tersedia');
    // }

    public function test_an_superadmin_can_create_new_webgis_administrator()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post(route('users.store', [
            'name' => 'Lois Di Nominator',
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'is_admin' => 0,
            'password' => 'password',
        ]));
        $response->assertValid();
        $response->assertRedirect();
    }

    public function test_correct_data_must_be_provided_to_create_new_webgis_administrator()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->post(route('users.store', [
            'name' => '',
            'email' => '',
            'username' => '',
            'gender' => '',
            'password' => '',
        ]));
        $response->assertInvalid();
    }

    public function test_a_edit_page_can_be_rendered()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('users.edit', ['user' => $this->otherUser]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_an_superadmin_can_update_webgis_administrator()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put(route('users.update', ['user' => $this->otherUser]), [
            'name' => 'Micahel John Doe',
            'username' => 'johdoe_mic',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'michaeljohndoe@example.com',
        ]);
        $response->assertValid();
        $response->assertRedirect();
    }

    public function test_correct_data_must_be_provided_to_update_webgis_administrator()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->put(route('users.update', ['user' => $this->otherUser]), [
            'name' => '',
            'username' => '',
            'email' => '',
            'username' => '',
            'gender' => '',
        ]);
        $response->assertInvalid();
    }

    public function test_an_superadmin_can_delete_webgis_administrator()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->delete(route('users.destroy', ['user' => $this->otherUser]));
        $response->assertRedirect();
    }

    public function test_an_webgis_administrator_cannot_create_new_webgis_administrator()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->post(route('users.store', [
            'name' => 'Lois Di Nominator',
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'is_admin' => 0,
            'password' => 'password',
        ]));
        $response->assertForbidden();
    }

    public function test_an_webgis_administrator_cannot_update_webgis_administrator()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->put(route('users.update', ['user' => $this->otherUser]), [
            'name' => 'Micahel John Doe',
            'username' => 'johdoe_mic',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'michaeljohndoe@example.com',
        ]);
        $response->assertForbidden();
    }

    public function test_an_webgis_administrator_cannot_delete_webgis_administrator()
    {
        $this->assertEquals(0, $this->webgisAdmin->is_admin);
        $response = $this->actingAs($this->webgisAdmin)->delete(route('users.destroy', ['user' => $this->otherUser]));
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_create_new_webgis_administrator()
    {
        $response = $this->post(route('users.store', [
            'name' => 'Lois Di Nominator',
            'email' => 'loisdinominator@example.com',
            'username' => 'loisdinominator',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'is_admin' => 0,
            'password' => 'password',
        ]));
        $this->assertGuest();
        $response->assertRedirect();
    }

    public function test_an_guest_cannot_update_webgis_administrator()
    {
        $response = $this->put(route('users.update', ['user' => $this->webgisAdmin->username]), [
            'name' => 'Micahel John Doe',
            'username' => 'johdoe_mic',
            'address' => 'Desa Sumberbening, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'michaeljohndoe@example.com',
        ]);
        $this->assertGuest();
        $response->assertRedirect();
    }

    public function test_an_guest_cannot_delete_webgis_administrator()
    {
        $response = $this->delete(route('users.update', ['user' => $this->webgisAdmin->id]));
        $this->assertGuest();
        $response->assertRedirect();
    }

    public function test_an_superadmin_can_see_webgis_administrator_profile()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('users.show', ['user' => $this->otherUser]));
        $response->assertStatus(200);
        $this->assertEquals('John Doe', $this->otherUser->name);
        $this->assertEquals('johndoe', $this->otherUser->username);
        $this->assertEquals('Desa Cakul, Kecamatan Dongko', $this->otherUser->address);
        $this->assertEquals('081234567890', $this->otherUser->phone_number);
        $this->assertEquals('johndoe@example.com', $this->otherUser->email);
        $this->assertEquals(0, $this->otherUser->is_admin);
    }

    public function test_an_superadmin_redirect_to_profile_update_route_if_want_to_change_the_data_itself()
    {
        $this->assertEquals(1, $this->superAdmin->is_admin);
        $response = $this->actingAs($this->superAdmin)->get(route('users.edit', ['user' => $this->superAdmin->username]));
        $response->assertRedirect(route('profile.edit'));
    }
}
