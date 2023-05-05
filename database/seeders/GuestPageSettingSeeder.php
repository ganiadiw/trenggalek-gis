<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuestPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('guest_page_settings')->insert([
            [
                'key' => 'page_title',
                'value' => json_encode(['Wisata Trenggalek']),
                'input_type' => 'text',
                'max_value' => 1,
            ],
            [
                'key' => 'welcome_message',
                'value' => json_encode(['Selamat datang di Sistem Informasi Pemetaan Wisata Kabupaten Trenggalek']),
                'input_type' => 'text',
                'max_value' => 1,
            ],
            [
                'key' => 'hero_image',
                'value' => json_encode([
                    null,
                    null,
                    null,
                    null,
                    null,
                ]),
                'input_type' => 'file',
                'max_value' => 5,
            ],
            [
                'key' => 'about_page',
                'value' => json_encode(['<p>Selamat datang di Sistem Informasi Pemetaan Wisata Kabupaten Trenggalek</p>']),
                'input_type' => 'textarea',
                'max_value' => 1,
            ],
        ]);
    }
}
