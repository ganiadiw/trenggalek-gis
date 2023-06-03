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

    const MAIN_URL = '/dashboard/page-settings/guest/';

    const HERO_IMAGE_PATH = 'page-settings/hero_image/';

    const IMAGE1 = '12345-image.png';

    const IMAGE2 = '56789-image.png';

    private $data = [
        'key' => 'hero_image',
        'value' => [self::IMAGE1, self::IMAGE2],
        'input_type' => 'file',
        'max_value' => 2,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create();
        $this->guestPageSetting = GuestPageSetting::factory()->create();

        $this->assertEquals(1, $this->superAdmin->is_admin);
    }

    public function test_super_admin_user_can_visit_the_guest_page_setting_page()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL);

        $response->assertStatus(200);
        $response->assertSeeText('Pengaturan Halaman');
        $response->assertSessionHasNoErrors();
    }

    public function test_edit_guest_page_setting_is_displayed()
    {
        $response = $this->actingAs($this->superAdmin)->get(self::MAIN_URL . $this->guestPageSetting->id);

        $response->assertStatus(200);
        $response->assertSeeText('Edit Data Pengaturan Halaman');
        $response->assertSessionHasNoErrors();
    }

    public function test_text_field_can_be_updated()
    {
        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $this->guestPageSetting->id, [
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
        Storage::put(self::HERO_IMAGE_PATH . self::IMAGE1, '');
        Storage::put(self::HERO_IMAGE_PATH . self::IMAGE2, '');
        $pageSetting = GuestPageSetting::factory()->create($this->data);

        $response = $this->actingAs($this->superAdmin)->put(self::MAIN_URL . $pageSetting->id, [
            'value_image' => [
                UploadedFile::fake()->image('54321-image.png'),
                UploadedFile::fake()->image('98765-image.png'),
            ],
        ]);

        $response->assertValid('value_image');
        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();

        $pageSetting = GuestPageSetting::where('key', 'hero_image')->first();

        $this->assertDatabaseMissing('guest_page_settings', [
            'value' => [self::IMAGE1, self::IMAGE2],
        ]);
        $this->assertFalse(Storage::exists(self::HERO_IMAGE_PATH . self::IMAGE1));
        $this->assertFalse(Storage::exists(self::HERO_IMAGE_PATH . self::IMAGE2));
        $this->assertTrue(Storage::exists(self::HERO_IMAGE_PATH . $pageSetting->value[0]));
        $this->assertTrue(Storage::exists(self::HERO_IMAGE_PATH . $pageSetting->value[1]));
    }

    public function test_image_file_can_be_deleted()
    {
        Storage::put(self::HERO_IMAGE_PATH . self::IMAGE1, '');
        Storage::put(self::HERO_IMAGE_PATH . self::IMAGE2, '');
        $pageSetting2 = GuestPageSetting::factory()->create($this->data);

        $response = $this->actingAs($this->superAdmin)->deleteJson(self::MAIN_URL . 'delete-image/' . $pageSetting2->key . '/' . self::IMAGE1);

        $response->assertStatus(200);

        $this->assertFalse(Storage::exists(self::HERO_IMAGE_PATH . self::IMAGE1));
    }
}
