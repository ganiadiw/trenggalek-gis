<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubDistrict>
 */
class SubDistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => '3503020',
            'name' => 'MUNJUNGAN',
            'latitude' => '-8.3030696',
            'longitude' => '111.5768607',
            'fill_color' => '#16a34a'
        ];
    }
}
