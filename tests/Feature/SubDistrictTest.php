<?php

namespace Tests\Feature;

use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubDistrictTest extends TestCase
{
    public function test_an_superadmin_can_see_sub_district_management_page()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('sub-districts.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Kelola Data Kecamatan');
    }

    public function test_a_create_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('sub-districts.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Data Kecamatan');
    }

    public function test_an_superadmin_can_create_new_sub_district_management()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->post(route('sub-districts.store', [
            'code' => '3503010',
            'name' => 'Panggul',
            'latitude' => -8.2402961,
            'longitude' => 111.4484781,
            'fill_color' => '#0ea5e9'
        ]));
        $response->assertValid(['code', 'name', 'latitude', 'longitude', 'fill_color']);
        $response->assertRedirect();
    }

    public function test_correct_data_must_be_provided_to_create_new_webgis_administrator()
    {
        $user = User::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->post(route('sub-districts.store', [
            'code' => '',
            'name' => '',
            'latitude' => '',
            'longitude' => '',
            'fill_color' => ''
        ]));
        $response->assertInvalid();
    }

    public function test_a_edit_page_can_be_rendered()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();

        $this->assertEquals(1, $user->is_admin);
        $response = $this->actingAs($user)->get(route('sub-districts.edit', ['sub_district' => $subDistrict]));
        $response->assertStatus(200);
        $response->assertSeeText('Ubah Data Kecamatan');
    }

    public function test_an_superadmin_can_update_webgis_administrator()
    {
        $user = User::factory()->create();
        $subDistrict = SubDistrict::factory()->create();

        $this->assertEquals(1, $user->is_admin);

        $response = $this->actingAs($user)->put(route('sub-districts.update', ['sub_district' => $subDistrict]), [
            'code' => '3503020',
            'name' => 'KECAMATAN MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#059669'
        ]);
        $response->assertValid();
        $response->assertRedirect();
    }
}
