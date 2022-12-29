<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class WebgisAdministratorTest extends TestCase
{
    public function test_an_superadmin_can_see_webgis_administrator_management_page()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_a_webgis_administrator_create_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('users.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_an_superadmin_can_create_new_webgis_administrator()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->post(route('users.store', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
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
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->post(route('users.store', [
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
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johdoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'johdoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('users.edit', ['user' => $otherUser->username]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Administrator Sistem Informasi Geografis Wisata Trenggalek');
    }

    public function test_an_superadmin_can_update_webgis_administrator()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johdoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'johndoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->put(route('users.update', ['user' => $otherUser->username]), [
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
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johdoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'johndoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->put(route('users.update', ['user' => $otherUser->username]), [
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
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johdoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'johndoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->delete(route('users.destroy', ['user' => $otherUser->username]));
        $response->assertRedirect();
    }

    public function test_an_webgis_administrator_cannot_create_new_webgis_administrator()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);

        $this->assertEquals(0, $user->is_admin);
        $response = $this->actingAs($user)->post(route('users.store', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'is_admin' => 0,
            'password' => 'password',
        ]));
        $response->assertForbidden();
    }

    public function test_an_webgis_administrator_cannot_update_webgis_administrator()
    {
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johdoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'johndoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(0, $user->is_admin);
        $response = $this->actingAs($user)->put(route('users.update', ['user' => $otherUser->username]), [
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
        $user = User::factory()->create([
            'is_admin' => 0,
        ]);
        $otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johdoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'johndoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(0, $user->is_admin);
        $response = $this->actingAs($user)->delete(route('users.destroy', ['user' => $otherUser->username]));
        $response->assertForbidden();
    }

    public function test_an_guest_cannot_create_new_webgis_administrator()
    {
        $response = $this->post(route('users.store', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
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
        $user = User::factory()->create();

        $response = $this->put(route('users.update', ['user' => $user->id]), [
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
        $user = User::factory()->create();

        $response = $this->delete(route('users.update', ['user' => $user->id]));
        $this->assertGuest();
        $response->assertRedirect();
    }

    public function test_an_superadmin_can_see_webgis_administrator_profile()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'address' => 'Desa Cakul, Kecamatan Dongko',
            'phone_number' => '081234567890',
            'email' => 'johndoe@example.com',
            'is_admin' => 0,
        ]);

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('users.show', ['user' => $otherUser->username]));
        $response->assertStatus(200);
        $this->assertEquals('John Doe', $otherUser->name);
        $this->assertEquals('johndoe', $otherUser->username);
        $this->assertEquals('Desa Cakul, Kecamatan Dongko', $otherUser->address);
        $this->assertEquals('081234567890', $otherUser->phone_number);
        $this->assertEquals('johndoe@example.com', $otherUser->email);
        $this->assertEquals(0, $otherUser->is_admin);
    }
}