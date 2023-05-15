<?php

namespace Tests\Feature\PageSetting;

use App\Models\GuestPageSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuestPageSettingTest extends TestCase
{
    private User $user;

    private GuestPageSetting $guestPageSetting;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->guestPageSetting = GuestPageSetting::factory()->create();
    }

    public function test_an_authenticated_user_can_see_guest_page_setting_page()
    {
        $this->assertEquals(1, $this->user->is_admin);
        $response = $this->actingAs($this->user)->get('/dashboard/page-settings/guest');
        $response->assertStatus(200);
        $response->assertSeeText('Pengaturan Halaman');
    }

    public function test_update_guest_page_setting_is_displayed()
    {
        $this->assertEquals(1, $this->user->is_admin);
        $response = $this->actingAs($this->user)->get('/dashboard/page-settings/guest/' . $this->guestPageSetting->id);
        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Pengaturan Halaman');
    }

    public function test_text_field_can_be_updated()
    {
        $this->assertEquals(1, $this->user->is_admin);
        $response = $this->actingAs($this->user)->put('/dashboard/page-settings/guest/' . $this->guestPageSetting->id, [
            'value_text' => [
                'Destinasi Wisata Trenggalek',
            ],
        ]);
        $response->assertValid('value_text');
        $response->assertRedirect(url()->previous());
        $this->assertDatabaseMissing('guest_page_settings', [
            'value' => ['Wisata Trenggalek'],
        ]);
        $this->assertDatabaseHas('guest_page_settings', [
            'value' => '["Destinasi Wisata Trenggalek"]',
        ]);
    }

    public function test_file_field_can_be_updated()
    {
        Storage::disk('local')->put('public/page-settings/hero_image/12345-image.png', '');
        Storage::disk('local')->put('public/page-settings/hero_image/56789-image.png', '');
        $guestPageSetting = GuestPageSetting::factory()->create([
            'key' => 'hero_image',
            'value' => ['12345-image.png', '56789-image.png'],
            'input_type' => 'file',
            'max_value' => 2,
        ]);

        $this->assertEquals(1, $this->user->is_admin);
        $response = $this->actingAs($this->user)->put('/dashboard/page-settings/guest/' . $guestPageSetting->id, [
            'value_image' => [
                UploadedFile::fake()->image('54321-image.png'),
                UploadedFile::fake()->image('98765-image.png'),
            ],
        ]);
        $response->assertValid('value_image');
        $response->assertRedirect(url()->previous());
        $guestPageSetting = GuestPageSetting::where('key', 'hero_image')->first();
        $this->assertDatabaseMissing('guest_page_settings', [
            'value' => ['12345-image.png', '98765-image.png'],
        ]);
        $this->assertFalse(Storage::exists('public/page-settings/hero_image/12345-image.png'));
        $this->assertFalse(Storage::exists('public/page-settings/hero_image/56789-image.png'));
        $this->assertTrue(Storage::exists('public/page-settings/hero_image/' . $guestPageSetting->value[0]));
        $this->assertTrue(Storage::exists('public/page-settings/hero_image/' . $guestPageSetting->value[1]));
    }

    public function test_image_file_can_be_deleted()
    {
        Storage::disk('local')->put('public/page-settings/hero_image/12345-image.png', '');
        Storage::disk('local')->put('public/page-settings/hero_image/56789-image.png', '');
        $guestPageSetting = GuestPageSetting::factory()->create([
            'key' => 'hero_image',
            'value' => ['12345-image.png', '56789-image.png'],
            'input_type' => 'file',
            'max_value' => 2,
        ]);

        $this->assertEquals(1, $this->user->is_admin);
        $response = $this->actingAs($this->user)->deleteJson('/dashboard/page-settings/guest/delete-image/' . $guestPageSetting->key . '/' . '12345-image.png');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Delete image successfully',
        ]);
        $this->assertFalse(Storage::exists('public/page-settings/hero_image/12345-image.png'));
    }
}
