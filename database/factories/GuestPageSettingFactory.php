<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuestPageSetting>
 */
class GuestPageSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'key' => 'page_title',
            'value' => ['Wisata Trenggalek'],
            'input_type' => 'text',
            'max_value' => 1,
        ];
    }
}
