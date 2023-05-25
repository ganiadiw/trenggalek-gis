<?php

namespace Tests\Feature\PageSetting;

use App\Models\GuestPageSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuestPageSettingTest extends TestCase
{
    private User $superAdmin;

    private GuestPageSetting $guestPageSetting;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->guestPageSetting = GuestPageSetting::factory()->create();

        $this->assertEquals(1, $this->superAdmin->is_admin);
    }

    public function test_super_admin_user_can_visit_the_guest_page_setting_page()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/page-settings/guest');

        $response->assertStatus(200);
        $response->assertSeeText('Pengaturan Halaman');
        $response->assertSessionHasNoErrors();
    }

    public function test_edit_guest_page_setting_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get('/dashboard/page-settings/guest/' . $this->guestPageSetting->id);

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Pengaturan Halaman');
        $response->assertSessionHasNoErrors();
    }

    public function test_text_field_can_be_updated()
    {
        $response = $this->actingAs($this->superAdmin)->put('/dashboard/page-settings/guest/' . $this->guestPageSetting->id, [
            'value_text' => [
                'Destinasi Wisata Trenggalek',
            ],
        ]);

        $response->assertValid('value_text');
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('guest_page_settings', [
            'value' => '["Destinasi Wisata Trenggalek"]',
        ]);
        $this->assertDatabaseMissing('guest_page_settings', [
            'value' => ['Wisata Trenggalek'],
        ]);
    }

    public function test_image_field_can_be_updated()
    {
        Storage::disk('local')->put('public/page-settings/hero_image/12345-image.png', '');
        Storage::disk('local')->put('public/page-settings/hero_image/56789-image.png', '');
        $guestPageSetting = GuestPageSetting::factory()->create([
            'key' => 'hero_image',
            'value' => ['12345-image.png', '56789-image.png'],
            'input_type' => 'file',
            'max_value' => 2,
        ]);

        $response = $this->actingAs($this->superAdmin)->put('/dashboard/page-settings/guest/' . $guestPageSetting->id, [
            'value_image' => [
                UploadedFile::fake()->image('54321-image.png'),
                UploadedFile::fake()->image('98765-image.png'),
            ],
        ]);

        $response->assertValid('value_image');
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

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

        $response = $this->actingAs($this->superAdmin)->deleteJson('/dashboard/page-settings/guest/delete-image/' . $guestPageSetting->key . '/' . '12345-image.png');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Delete image successfully',
        ]);

        $this->assertFalse(Storage::exists('public/page-settings/hero_image/12345-image.png'));
    }
}
